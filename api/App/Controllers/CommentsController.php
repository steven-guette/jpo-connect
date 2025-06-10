<?php
namespace App\Controllers;

use Core\Controller\CrudController;
use App\Entities\Comment;
use App\Services\CommentsService;

final class CommentsController extends CrudController {
    public function __construct() {
        parent::__construct(new CommentsService(), Comment::class);
    }
}