<?php
namespace App\Controllers;

use Core\Controller\CrudController;
use App\Entities\User;
use App\Services\UsersService;


final class UsersController extends CrudController {
    public  function __construct() {
        parent::__construct(new UsersService(), User::class);
    }
}