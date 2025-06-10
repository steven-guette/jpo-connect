<?php
namespace App\Models;

use Core\Model\CrudModel;
use App\Entities\Notification;

final class NotificationsModel extends CrudModel {
    public function __construct() {
        parent::__construct('notifications', Notification::class);
    }
}