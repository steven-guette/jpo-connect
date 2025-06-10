<?php
namespace App\Controllers;

use Core\Controller\BaseController;
use App\Services\NotificationsService;
use App\Entities\Notification;
use Core\Http\ApiResponse;
use JetBrains\PhpStorm\NoReturn;

final class NotificationsController extends BaseController {
    public function __construct() {
        parent::__construct(new NotificationsService(), Notification::class);
    }
    
    #[NoReturn] public function index(array $filters): void {
        $result = $this->serviceObj->getNotifications($filters);
        ApiResponse::success('read', $result);
    }
    
    #[NoReturn] public function show(int $id): void {
        $result = $this->serviceObj->getNotification($id);
        ApiResponse::success('read', $result);
    }
}