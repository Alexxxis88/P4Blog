<?php
class Manager
{  
    protected $_db = null;

    public function __construct(){
		$this->dbConnect();
	}

        
    // General protected function to connect to database
    protected function dbConnect()
    {
        $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
        $this->_db= $db;
    }
}