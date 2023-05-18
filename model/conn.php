<?php

class dbcon
{
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $database = 'ihrm_new';

    public static function dbhandler(){
        $dbhandle = new mysqli(self::$host, self::$username, self::$password, self::$database);
        return $dbhandle;
    }

    public function query($sql)
    {
        // Connect to the server
        $dbhandle = self::dbhandler();

        // If not connected to the server or the database
        if ($dbhandle->connect_error) {
            die("Could not connect to the server or database: " . $dbhandle->connect_error);
        }

        // Run the query
        $result = $dbhandle->query($sql);

        // If failed to run query
        if (!$result) {
            die("Could not run query: " . $dbhandle->error);
        }

        // Close the connection
        $dbhandle->close();

        return $result;
    }
}

?>
