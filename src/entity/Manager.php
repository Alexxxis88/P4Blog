<?php
class Manager
{
    protected $_db = null;
    protected $_host ='localhost';
    protected $_dbName ='p4blog';
    protected $_charset ='utf8';
    protected $_port ='3306';
    protected $_username = 'root';
    protected $_password = '';

    public function __construct()
    {
        $this->dbConnect();
    }

    // General protected function to connect to database
    protected function dbConnect()
    {
        try {
            $db = new PDO('mysql:host='. $this->_host.';dbname='. $this->_dbName.';charset='. $this->_charset.';port='. $this->_port,  $this->_username,  $this->_password);
            $this->_db= $db;
        }
        catch(Exception $e) {
            throw new Exception('La connexion à la base de donnée a échouée.');
        }

    }
}
