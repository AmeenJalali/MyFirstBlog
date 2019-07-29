<?php

namespace src\services\database;


class MySQLiQueryBuilder {

    private const INSERT = 0;
    private const SELECT = 1;
    private const UPDATE = 2;
    private const DELETE = 3;

    private $type;
    private $sql = "";
    private $tableName = "";


    private $sqlParts = [
        'select' => [],
        'from' => [],
        'where' => [],
        'set' => [],
        'orderBy' => [],
        'values' => []
    ];

    public function getSQL() : string {
        switch ($this->type) {
            case self::INSERT:
                $this->sql = $this->getSQLForInsert();
                break;
            case self::SELECT:
                $this->sql = $this->getSQLForSelect();
                break;
            case self::UPDATE:
                $this->sql = $this->getSQLForUpdate();
                break;
            case self::DELETE:
                $this->sql = $this->getSQLForDelete();
                break;
        }
        return $this->sql;
    }


    public function insert() {
        $this->type = self::INSERT;
        return $this;
    }

    public function inTo($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function addValues(array $values) {
        $this->sqlParts['values'] = $values;
        return $this;
    }

    public function set(array $keyValues) {
        $this->sqlParts['set'] = $keyValues;
        return $this;
    }


    public function from($from) {
        $this->sqlParts['from'] = is_array($from) ? $from : func_get_args();
        return $this;
    }

    public function orderBy($sort, $order = 'ASC') {
        $this->sqlParts['orderBy'] = func_get_args();
        return $this;
    }

    public function where($condition) {
        $this->sqlParts['where'] = is_array($condition) ? $condition : func_get_args();
        return $this;
    }


    public function select($select = null) {
        $this->type = self::SELECT;

        if (empty($select)) {
            return $this;
        }

        $this->sqlParts['select'] = is_array($select) ? $select : func_get_args();

        return $this;
    }

    public function all() {
        $this->sqlParts['select'] = ['*'];
        return $this;
    }

    public function update($tableName) {
        $this->type = self::UPDATE;
        $this->tableName = $tableName;
        return $this;
    }

    public function delete($tableName) {
        $this->type = self::DELETE;
        $this->tableName = $tableName;
        return $this;
    }

    private function getSQLForInsert() : string {
        $values = "";
        $keys = array_keys($this->sqlParts['values']);
        $lastKey = end($keys);
        foreach ($this->sqlParts['values'] as $key => $value) {
            if ($key != $lastKey) {
                $values .= "'" . $value . "', ";
            } else {
                $values .= "'" . $value . "'";
            }
        }
        return 'INSERT INTO ' . $this->tableName .
            ' (' . implode(', ', array_keys($this->sqlParts['values'])) . ') ' .
            "VALUES ($values)";
    }

    private function getSQLForSELECT() : string {
        $query = 'SELECT ' . implode(', ', $this->sqlParts['select']);
        $query .= ' FROM ' . implode(', ', $this->sqlParts['from']);
        empty($this->sqlParts['where']) ?: $query .= ' WHERE ' . implode(', ', $this->sqlParts['where']);
        empty($this->sqlParts['orderBy']) ?: $query .= ' ORDER BY ' . implode(' ', $this->sqlParts['orderBy']);

        return $query;
    }

    private function getSQLForUpdate() : string {
        $condition = "";
        $setQuery = "";
        foreach ($this->sqlParts['where'] as $key => $value) {
            $condition .= $key . '=' . $value;
        }
        $keys = array_keys($this->sqlParts['set']);
        $lastKey = end($keys);
        foreach ($this->sqlParts['set'] as $key => $value) {
            if ($key != $lastKey) {
                $setQuery .= $key . "='" . $value . "', ";
            } else {
                $setQuery .= $key . "='" . $value . "'";
            }
        }
        return 'UPDATE ' . $this->tableName . ' SET ' .
            $setQuery . ' WHERE ' . $condition;

    }

    private function getSQLForDelete() : string {
        $condition = "";
        foreach ($this->sqlParts['where'] as $key => $value) {
            $condition .= $key . '=' . $value;
        }
        // TODO -> AND / OR
        return 'DELETE FROM ' . $this->tableName .
            ' WHERE ' . $condition;
    }

}