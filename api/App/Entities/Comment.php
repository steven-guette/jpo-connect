<?php
namespace App\Entities;

use DateTime;
use Core\Entity;
use Core\Traits\ToDatabaseTrait;
use Exception;

final class Comment extends Entity {
    use ToDatabaseTrait;
    
    private ?int $userFk = null;
    private ?int $jpoEventFk = null;
    private ?int $parentCommentFk = null;
    
    private ?int $id = null;
    private ?string $content = null;
    private ?string $createdAt = null;
    private ?array $childComments = null;
    private bool $isVisible = true;
    
    private ?User $user = null;
    
    
    public function __construct(array $data = []) {
        parent::__construct($data);
        $this->setNonPersistedData(['created_at', 'user', 'jpo_event', 'child_comments']);
    }
    
    
    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getCreatedAtObject(): ?DateTime { return $this->createdAt ? new DateTime($this->createdAt) : null; }
    public function getUserObject(): ?User { return $this->user; }

    public function IsVisible(): bool { return $this->getIsVisible(); }

    
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    
    public function getContent(): ?string { return $this->content; }
    public function setContent(string $content): void { $this->content = $content; }

    public function getChildComments(): ?array { return $this->childComments; }
    public function setChildComments(array $childComments): void { $this->childComments = $childComments; }
    public function addChildComment(Comment $comment): void { $this->childComments[] = $comment; }
    
    public function getIsVisible(): bool { return $this->isVisible; }
    public function setIsVisible(bool $isVisible): void { $this->isVisible = $isVisible; }
    
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }
    
    public function getUserFk(): ?int { return $this->userFk; }
    public function setUserFk(int $userFk): void { $this->userFk = $userFk; }
    
    public function getJpoEventFk(): ?int { return $this->jpoEventFk; }
    public function setJpoEventFk(int $jpoEventFk): void { $this->jpoEventFk = $jpoEventFk; }
    
    public function getParentCommentFk(): ?int { return $this->parentCommentFk; }
    public function setParentCommentFk(int $parentCommentFk): void { $this->parentCommentFk = $parentCommentFk; }
    
    public function setUser(User $user): void { $this->user = $user; }
    public function getUser(): ?array { return $this->user->toArray() ?? null; }
}