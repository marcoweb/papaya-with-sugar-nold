<?php
namespace PapayaWithSugar;

use PDO;

class TableData {
    private string $tableName;

    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }

    public function select(array $criteriaArray = null) {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $queryParams = [];
        if(!is_null($criteriaArray)) {
            foreach($criteriaArray as $k => $v) {
                $paramName = ':' . $k;
                if(count($queryParams) > 0) {
                    $sql .= ' AND ';
                } else {
                    $sql .= ' WHERE ';
                }
                $sql .= $k . ' = ' . $paramName;
                $queryParams[$paramName] = $v;
            }
        }
        $query = DatabaseConnectionFactory::getDbConnection()->prepare($sql);
        $query->execute($queryParams);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $valuesArray) {
        $sql = 'INSERT INTO ' . $this->tableName . '(' . implode(',', array_keys($valuesArray)) . ') VALUES (';
        $queryParams = [];
        foreach($valuesArray as $k => $v) {
            $paramName = ':' . $k;
            if(count($queryParams) > 0) {
                $sql .= ', ';
            }
            $sql .= $paramName;
            $queryParams[$paramName] = $v;
        }
        $sql .= ')';
        $query = DatabaseConnectionFactory::getDbConnection()->prepare($sql);
        $query->execute($queryParams);
    }

    public function update(array $valuesArray, array $criteriaArray) {
        $sql = 'UPDATE ' . $this->tableName . ' SET ';
        $queryParams = [];
        foreach($valuesArray as $k => $v) {
            $paramName = ':' . $k;
            if(count($queryParams) > 0) {
                $sql .= ', ';
            }
            $sql .= $k . ' = ' . $paramName;
            $queryParams[$paramName] = $v;
        }
        foreach($criteriaArray as $k => $v) {
            $paramName = ':' . $k;
            if(count($queryParams) > count($valuesArray)) {
                $sql .= ' AND ';
            } else {
                $sql .= ' WHERE ';
            }
            $sql .= $k . ' = ' . $paramName;
            $queryParams[$paramName] = $v;
        }
        $query = DatabaseConnectionFactory::getDbConnection()->prepare($sql);
        $query->execute($queryParams);
    }

    public function delete(array $criteriaArray) {
        $sql = 'DELETE FROM ' . $this->tableName;
        $queryParams = [];
        foreach($criteriaArray as $k => $v) {
            $paramName = ':' . $k;
            if(count($queryParams) > 0) {
                $sql .= ' AND ';
            } else {
                $sql .= ' WHERE ';
            }
            $sql .= $k . ' = ' . $paramName;
            $queryParams[$paramName] = $v;
        }
        $query = DatabaseConnectionFactory::getDbConnection()->prepare($sql);
        $query->execute($queryParams);
    }
}