<?php
namespace App\Models;

use App\Entities\JpoEvent;
use App\Entities\Location;
use Core\Model\CrudModel;
use Exception;

final class JpoEventsModel extends CrudModel {
    public function __construct() {
        parent::__construct('jpo_events', JpoEvent::class);
    }
    
    public function findById(int $id): ?JpoEvent {
        $query = '
            SELECT e.*, l.id as locations_id, l.city as locations_city, l.street_number as locations_street_number,
                   l.street_name as locations_street_name, l.zip_code as locations_zip_code, l.gps_coordinates as locations_gps_coordinates
            FROM jpo_events e
            LEFT JOIN locations l ON e.location_fk = l.id
            WHERE e.id = :event_id;
        ';
        
        $this->sqlQuery($query, ['event_id' => $id]);
        $sqlResult = $this->cursor->fetch();
        return $this->buildEventObject($sqlResult);
    }
    
    public function findAll(array $filters): array {
        $query = '
            SELECT e.*, l.id as locations_id, l.city as locations_city, l.street_number as locations_street_number,
                   l.street_name as locations_street_name, l.zip_code as locations_zip_code, l.gps_coordinates as locations_gps_coordinates
            FROM jpo_events e
            LEFT JOIN locations l ON e.location_fk = l.id
        ' . $this->buildClauses($filters) . ';';
        
        $this->sqlQuery($query, $filters);
        $sqlResult = $this->cursor->fetchAll();
        return array_map(fn($item) => $this->buildEventObject($item), $sqlResult);
    }
    
    /**
     * @param int $eventId
     * @return bool
     * @throws Exception
     */
    public function addRegistration(int $eventId): bool {
        $query = 'UPDATE jpo_events SET current_registered = current_registered + 1 WHERE id = :event_id;';
        return $this->sqlQuery($query, ['event_id' => $eventId]);
    }
    
    /**
     * @param int $eventId
     * @return bool
     * @throws Exception
     */
    public function removeRegistration(int $eventId): bool {
        $query = 'UPDATE jpo_events SET current_registered = current_registered - 1 WHERE id = :event_id;';
        return $this->sqlQuery($query, ['event_id' => $eventId]);
    }
    
    /**
     * @param bool|array $sqlResult
     * @return JpoEvent
     * @throws Exception
     */
    public function buildEventObject(bool|array $sqlResult): JpoEvent {
        if (empty($sqlResult)) {
            throw new Exception("Aucun événement ne correspond à la recherche.");
        }
        
        $location = new Location();
        $this->fastHydrate($sqlResult, $location, 'locations');
        
        $event = new JpoEvent($sqlResult);
        $event->setLocation($location);
        
        return $event;
    }
}