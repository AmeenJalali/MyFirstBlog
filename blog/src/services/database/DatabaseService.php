<?php

namespace src\services\database;

interface DatabaseService
{
    public static function insert(string $table, array $values) : int;
    public static function select(string $table, int $id) : array;
    public static function update(string $table, int $id, array $values) : bool;
    public static function delete(string $table, int $id) : bool;
}