<?php

/**
 * Single shared MySQL connection (singleton).
 * Settings come from DB_HOST, DB_USER, DB_PASSWORD and DB_NAME with XAMPP defaults.
 */
class Database
{
    private $_connection;
    private static $_instance; //The single instance
    // Defaults suit a local XAMPP setup. Set DB_HOST, DB_USER, DB_PASSWORD and DB_NAME to override them.
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "schoolmanagement";
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    public function __construct()
    {
        $this->_host = getenv('DB_HOST') ?: $this->_host;
        $this->_username = getenv('DB_USER') ?: $this->_username;
        $this->_password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : $this->_password;
        $this->_database = getenv('DB_NAME') ?: $this->_database;
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error(
                "Failed to connect to MySQL: " . mysqli_connect_error(),
                E_USER_ERROR
            );
        }
    }
    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }
    // Get mysqli connection
    public function getConnection()
    {
        return $this->_connection;
    }
}
