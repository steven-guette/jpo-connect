<?php
namespace Core;

use PDO;
use PDOStatement;
use Exception;

abstract class Database {
    private ?PDO $pdo;
    protected ?PDOStatement $cursor = null;
    
    private ?string $tableName = null;
    private array $columns = [];
    
    /**
     * Constructeur
     * @param string $tableName
     * @throws Exception
     */
    public function __construct(string $tableName) {
        $this->connect();
        $this->setTableName($tableName);
        $this->setColumns();
    }
    
    public function __destruct() {
        $this->clearCursor();
        $this->disconnect();
    }
    
    /**
     * Connexion à la base de données
     * @return void
     * @throws Exception
     */
    private function connect(): void {
        try {
            $this->pdo = new PDO(
                "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8",
                $_ENV['DB_USER'], $_ENV['DB_PASS']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (Exception $err) {
            throw new Exception("Une erreur est survenue lors de la connexion à la base de donnée.\nErreur: {$err->getMessage()}");
        }
    }
    
    /**
     * Méthode générique pour centraliser toutes les requêtes
     * Permet aux modèles de pouvoir effectuer, si nécessaire, des requêtes spécifiques sans être dépendant
     * des méthodes génériques de Database
     * @param string $query
     * @param array $params
     * @return bool
     * @throws Exception
     */
    protected function sqlQuery(string $query, array $params = []): bool {
        if (!$this->tableName) {
            throw new Exception("Aucune table n'a été sélectionnée pour la requête.");
        } else if (!$this->pdo) {
            $this->connect();
        }
        
        try {
            $this->cursor = $this->pdo->prepare($query);
            $this->bindDataValues($params);
            return $this->cursor->execute();
        } catch (Exception $err) {
            throw new Exception("Une erreur est survenue lors de l'exécution de la requête suivante :\n- $query\nErreur : {$err->getMessage()}");
        }
    }
    
    /**
     * Bind les valeurs des placeholders
     * @param array $params
     * @return void
     */
    private function bindDataValues(array $params): void {
        foreach ($params as $placeholder => $value) {
            $this->cursor->bindValue($placeholder, $value, $this->getBindType($value));
        }
    }
    
    /**
     * Créer une nouvelle entrée dans la table
     * @param array $data
     * @return int|false
     * @throws Exception
     */
    protected function create(array $data): int|false {
        if (empty($data)) return false;
        
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($v) => ":$v", array_keys($data)));
        $query = "INSERT INTO $this->tableName ($fields) VALUES ($placeholders);";
        
        return $this->sqlQuery($query, $data)
            ? (int)$this->pdo->lastInsertId()
            : false;
    }
    
    /**
     * @param array $clauses
     * @param array $columns
     * @param bool $one
     * @return array
     * @throws Exception
     *
     */
    private function read(array $clauses = [], array $columns = ['*'], bool $one = false): array {
        $fields = implode(', ', $columns);
        $query = "SELECT $fields FROM $this->tableName" . $this->buildClauses($clauses) . ';';
        $this->sqlQuery($query, $clauses);

        try {
            $result = $one ? $this->cursor->fetch() : $this->cursor->fetchAll();
            return $result ?: [];
        } catch (Exception $e) {
            throw new Exception("Une erreur est survenue lors de la récupération des données de la table $this->tableName.\nErreur: {$e->getMessage()}");
        }
    }

    /**
     * Récupère un élément de la table en se basant sur les filtres
     * @param array $clauses
     * @param array $columns
     * @return array
     * @throws Exception
     */
    protected function readOne(array $clauses, array $columns = ['*']): array {
        return $this->read($clauses, $columns, true);
    }
    
    /**
     * Récupère tous les éléments de la table, avec la possibilité d'appliquer des filtres
     * @param array $clauses
     * @param array $columns
     * @return array
     * @throws Exception
     */
    protected function readAll(array $clauses = [], array $columns = ['*']): array {
        return $this->read($clauses, $columns);
    }
    
    /**
     * Modifier l'entrée de la table correspondant à l'ID renseigné
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    protected function update(int $id, array $data): bool {
        $setters = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $query = "UPDATE $this->tableName SET $setters WHERE id = :id;";
        return $this->sqlQuery($query, [ 'id' => $id, ...$data ]);
    }
    
    /**
     * Supprimer l'entrée de la table correspondante à l'ID renseigné
     * @param int $id
     * @return bool
     * @throws Exception
     */
    protected function delete(int $id): bool {
        $query = 'DELETE FROM ' . $this->tableName . ' WHERE id = :id;';
        return $this->sqlQuery($query, ['id' => $id]);
    }
    
    /**
     * Vérifie si la table ciblée existe dans la database
     * @param string $tableName
     * @return bool
     * @throws Exception
     */
    private function tableExists(string $tableName): bool {
        $this->cursor = $this->pdo->prepare("SHOW TABLES;");
        $this->cursor->execute();
        $tablesList = array_map(fn($row) => array_values($row)[0], $this->cursor->fetchAll());
        $this->clearCursor();
        
        return in_array($tableName, $tablesList);
    }
    
    /**
     * Construit dynamiquement les clauses SQL à partir des filtres fournis.
     * Cette méthode supporte uniquement :
     * Des conditions de type AND dans la clause WHERE
     * Un GROUP BY simple
     * Un ORDER BY simple avec direction
     * Un LIMIT/OFFSET
     *
     * Ne gère pas :
     * Les jointures (JOIN)
     * Les alias de colonnes ou de tables
     * Les conditions complexes (OR, IN, BETWEEN, etc.)
     *
     * @param array $filters
     * @return string
     */
    protected function buildClauses(array &$filters): string {
        $otherClauses = $this->getOtherClauses($filters);
        $whereClauses = $this->getWhereClauses($filters);
        
        $formattedClauses = '';
        if (!empty($whereClauses)) {
            $formattedClauses .= ' WHERE ' . $whereClauses;
        }
        
        $formattedClauses .= $otherClauses;
        return $formattedClauses;
    }
    
    /**
     * Nettoyer le curseur PDOStatement
     * @return void
     */
    protected function clearCursor(): void {
        $this->cursor = null;
    }
    
    /**
     * Ferme la connexion PDO
     * @return void
     */
    protected function disconnect(): void {
        $this->pdo = null;
    }
    
    /**
     * Retourne le typage de la valeur que l'on souhaite binder
     * @param $bindValue
     * @return int
     */
    private function getBindType($bindValue): int {
        return match (gettype($bindValue)) {
            'integer'   => PDO::PARAM_INT,
            'boolean'   => PDO::PARAM_BOOL,
            'NULL'      => PDO::PARAM_NULL,
            default     => PDO::PARAM_STR
        };
    }
    
    /**
     * Retourne une chaîne correspondante à toutes les clauses qui ne sont pas de type WHERE
     * @param array $filters
     * @return string
     */
    private function getOtherClauses(array &$filters): string {
        $clauses = '';
        
        if (isset($filters['group_by']) && in_array($filters['group_by'], $this->columns, true)) {
            $clauses .= " GROUP BY {$filters['group_by']}";
        }
        
        if (isset($filters['order_by'])) {
            if (in_array($filters['order_by'], $this->columns, true)) {
                $direction = isset($filters['order_dir']) && strtolower($filters['order_dir']) === 'asc' ? 'ASC' : 'DESC';
                $clauses .= " ORDER BY {$filters['order_by']} $direction";
            }
        }
        
        if (isset($filters['limit'])) {
            $limit = is_numeric($filters['limit'])                                  ? (int) $filters['limit']   : 20;
            $offset = isset($filters['offset']) && is_numeric($filters['offset'])   ? (int) $filters['offset']  : 0;
            $clauses .= " LIMIT $limit OFFSET $offset";
        }
        
        unset($filters['group_by'], $filters['order_by'], $filters['order_dir'], $filters['limit'], $filters['offset']);
        return $clauses;
    }
    
    /**
     * Retourne une chaîne correspondante à toutes les clauses de type WHERE
     * @param array $filters
     * @return string
     */
    private function getWhereClauses(array $filters): string {
        $clauses = [];
        foreach (array_keys($filters) as $key) {
            if (in_array($key, $this->columns, true)) {
                $clauses[] = "$key = :$key";
            }
        }
        return implode(' AND ', $clauses);
    }
    
    /**
     * Modifie la table cible lors des requêtes à la database
     * @param string $tableName
     * @return void
     * @throws Exception
     */
    private function setTableName(string $tableName): void {
        if (!$this->tableExists($tableName)) {
            throw new Exception("La table $tableName n'existe pas dans la base de donnée.");
        }
        $this->tableName = $tableName;
    }
    
    /**
     * Initialise la liste des champs disponibles dans la table
     * @return void
     * @throws Exception
     */
    private function setColumns(): void {
        $this->sqlQuery("DESCRIBE $this->tableName;");
        $this->columns = array_column($this->cursor->fetchAll(), 'Field');
    }
    protected function getColumns(): array {
        return $this->columns;
    }
}