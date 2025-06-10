<?php
namespace App\Controllers;

use Exception;

use Core\Controller\CrudController;
use App\Services\LocationsService;
use App\Entities\Location;

final class LocationsController extends CrudController {
    public function __construct() {
        parent::__construct(new LocationsService(), Location::class);
    }
}