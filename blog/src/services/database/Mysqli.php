<?php

namespace src\services\database;

use mysqli_sql_exception;

abstract class Mysqli implements DatabaseService {

    public static function insert(string $table, array $data): int {
        $connection = get_connection();
        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->insert()
            ->inTo($table)
            ->addValues($data)
            ->getSQL();


//        $separated_key_values = separate_key_values($data);
//        $columns = $separated_key_values['columns'];
//        $values = $separated_key_values['values'];
//        $sql = "insert into $columns values $values;";


        $query = mysqli_query($connection, $sql);
        if (!$query) {
            die(mysqli_error($connection));
        }
        $insertedID = $connection->insert_id;
        close_database_connection($connection);
        return $insertedID;
    }

    public static function select(string $table, int $id) : array {
        $connection = get_connection();

        $queryBuilder = new MysqliQueryBuilder;
        $sql = $queryBuilder->select()
            ->from($table)
            ->where(
                [
                    'id' => $id
                ]
            )
            ->getSQL();

        echo $sql;

//        $sql = "select * from $table where id=$id;";
//        $query = mysqli_query($connection, $sql);
//        if (!$query) {
//            die(mysqli_error($connection));
//        }
//        $data = array();
//        if ($query->num_rows > 0) {
//            $i = 0;
//            while ($row = $query->fetch_assoc()) {
//                $data[$i] = $row;
//                $i++;
//            }
//        }
//        close_database_connection($connection);
//        return $data;
        return [];
    }

    public static function update(string $table, int $id, array $data): bool {
        $connection = get_connection();
//        $changes = "";
//        $lastKey = end(array_keys($data));
//        foreach ($data as $key => $value) {
//            if ($key != $lastKey) {
//                $changes .= $key . '=' . $value . ',';
//            } else {
//                $changes .= $key . '=' . $value;
//            }
//        }
//        echo "update $table set $changes where id=$id";
//        $sql = "update $table set $changes where id=$id;";

        $queryBuilder = new MysqliQueryBuilder;

        $sql = $queryBuilder->update($table)
            ->set($data)
            ->where(
                [
                    'id' => $id
                ]
            )
            ->getSQL();
        echo $sql;
        $query = mysqli_query($connection, $sql);
        close_database_connection($connection);
        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public static function delete(string $table, int $id): bool {
        $connection = get_connection();

        $queryBuilder = new MysqliQueryBuilder;

        $sql = $queryBuilder->delete($table)
            ->where(
                [
                    'id' => $id
                ]
            )
            ->getSQL();
//        $sql = "delete from $table where id=$id;";
        $query = mysqli_query($connection, $sql);
        close_database_connection($connection);
        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public static function execute($sql) {
        $connection = get_connection();
        if ($connection) {
            create_database_connection($connection);
            $query = mysqli_query($connection, $sql);
            if (!$query) {
                die(mysqli_error($connection));
            }

            $data = array();
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $data[$i] = $row;
                    $i++;
                }
            }
            return $data;
        } else {
            return null;
        }
    }
}

function separate_key_values(array $array) : array {
    $columns = implode(", ", array_keys($array));
    $escaped_values = array_map('mysqli_real_escape_string', array_values($array));
    $values = implode(", ", $escaped_values);
    return array(
        'columns' => $columns,
        'values' => $values
    );
}

function get_connection() {
    try {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection) {
            die('Error - Couldn\'t connect to database.');
        } else {
            return $connection;
        }
    } catch (mysqli_sql_exception $exception) {
        die("Unfortunately, the details you entered for database connection are incorrect! " . $exception);
    }
}

function close_database_connection($connection) {
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

