<?php
namespace App\Controllers;

use Core\Controller\CrudController;
use App\Entities\Registration;
use App\Services\RegistrationsService;

final class RegistrationsController extends CrudController {
    public function __construct() {
        parent::__construct(new RegistrationsService(), Registration::class);
    }
}