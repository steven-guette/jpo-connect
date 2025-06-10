<?php
namespace App\Models;

use App\Entities\Comment;
use App\Entities\User;
use Core\Model\CrudModel;
use Exception;

final class CommentsModel extends CrudModel {
    public function __construct() {
        parent::__construct('comments', Comment::class);
    }
    
    public function findAll(array $filters): array {
        $query = '
            SELECT c.*, u.id as users_id, u.name as users_name, u.firstname as users_firstname, u.role_id as users_role_id, l.id as location_id
            FROM comments c
            INNER JOIN users u ON c.user_fk = u.id
            LEFT JOIN locations l ON u.location_fk = l.id
        ' . $this->buildClauses($filters) . ' ORDER BY c.created_at DESC;';
        
        $this->sqlQuery($query, $filters);
        $comments = array_map(fn($item) => $this->buildCommentObject($item), $this->cursor->fetchAll());

        $rootComments = [];
        $repliesComments = [];

        foreach ($comments as $comment) {
            $parentId = $comment->getParentCommentFk();
            if ($parentId) {
                $repliesComments[$parentId][] = $comment;
            } else {
                $rootComments[$comment->getId()] = $comment;
            }
        }

        foreach ($rootComments as $parentId => $parent) {
            $parent->setChildComments($repliesComments[$parentId] ?? []);
        }

        return $rootComments;
    }
    
    public function findById(int $id): ?Comment {
        $query = '
            SELECT c.*, u.id as users_id, u.name as users_name, u.firstname as users_firstname, u.role_id as users_role_id, l.id as location_id
            FROM comments c
            INNER JOIN users u ON c.user_fk = u.id
            LEFT JOIN locations l ON u.location_fk = l.id
            WHERE c.id = :comment_id OR c.parent_comment_fk = :comment_id
            ORDER BY c.created_at DESC;
        ';
        
        $this->sqlQuery($query, ['comment_id' => $id]);
        $comments = $this->cursor->fetchAll();

        $rootComment = null;
        $repliesComments = [];

        foreach ($comments as $comment) {
            if ($comment['id'] !== $id) {
                $repliesComments[] = $this->buildCommentObject($comment);
                continue;
            }
            $rootComment = $this->buildCommentObject($comment);
        }

        $rootComment?->setChildComments($repliesComments);
        return $rootComment;
    }
    
    /**
     * @param bool|array $sqlResult
     * @return Comment
     * @throws Exception
     */
    private function buildCommentObject(bool|array $sqlResult): Comment {
        if (empty($sqlResult)) {
            throw new Exception("Aucun commentaire disponible.");
        }
        
        $user = new User();
        $this->fastHydrate($sqlResult, $user, 'users');
        
        $comment = new Comment($sqlResult);
        $comment->setUser($user);
        
        return $comment;
    }
}