<?php

class dbcon
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'ihrm_new';

    public function query($sql)
    {
        // Connect to the server
        $dbhandle = new mysqli($this->host, $this->username, $this->password, $this->database);

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
