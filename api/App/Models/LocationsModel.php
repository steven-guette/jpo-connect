<?php
namespace App\Models;

use App\Entities\Location;
use Core\Model\CrudModel;

final class LocationsModel extends CrudModel {
    public function __construct() {
        parent::__construct('locations', Location::class);
    }
}