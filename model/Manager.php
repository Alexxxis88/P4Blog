<?php
class Manager
{  
        
    // General protected function to connect to database
    protected function dbConnect()
    {
        $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
        return $db;
    }
}