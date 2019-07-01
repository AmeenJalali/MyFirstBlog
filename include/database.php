<?php

function get_connection() {
    try {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        return $connection;
    } catch (mysqli_sql_exception $e) {
        echo("Unfortunately, the details you entered for connection are incorrect!");
    }
}

function create_database_connection($connection) {
    if (!$connection) {
        die('Error - Couldn\'t connect to database.');
    }
}

function close_database_connection($connection) {
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

function run_sql($sql) {
    $connection = get_connection();
    create_database_connection($connection);
    $query = mysqli_query($connection, $sql);
    if (!$query) {
        die(mysqli_error($connection));
    }
    close_database_connection($connection);
}

function run_sql_with_return($sql)
{
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

function sql_count($sql) {
    $connection = get_connection();
    if ($connection) {
        create_database_connection($connection);
        $result = mysqli_query($connection, $sql);
        if ($result != null) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    foreach ($row as $r) {
                        return $r;
                    }
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        close_database_connection($connection);
    } else {
        return 0;
    }
}

