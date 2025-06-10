<?php
namespace App\Controllers;

use App\Entities\JpoEvent;
use App\Services\JpoEventsService;
use Core\Controller\CrudController;

final class JpoEventsController extends CrudController {
    public function __construct() {
        parent::__construct(new JpoEventsService(), JpoEvent::class);
    }
}