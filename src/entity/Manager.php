<?php
class Manager
{
    protected $_db = null;

    public function __construct()
    {
        $this->dbConnect();
    }

    // General protected function to connect to database
    protected function dbConnect()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->_db= $db;
        }
        catch(Exception $e) {
            throw new Exception('La connexion à la base de donnée a échouée.');
        }

    }
}
