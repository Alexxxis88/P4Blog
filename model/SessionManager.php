<?php

require_once("model/Manager.php");

class SessionManager extends Manager
{
    public function checkSession()
    {
    //we check wether the member is registered with COOKIE or SESSION
    if(isset($_COOKIE['id'])){
        $cookieOrSessionID = $_COOKIE['id'];
        }
        elseif(isset($_SESSION['id'])){
            $cookieOrSessionID = $_SESSION['id'];
        }
    return $cookieOrSessionID;
    }
    
    public function insertMember($username, $pass, $email)
    {
        $db = $this->dbConnect();
        $newMember = $db->prepare('INSERT INTO members( username, pass, email, registration_date) VALUES(?, ?, ?, NOW())');
        $newMember->execute(array($username, $pass, $email));
    }
    
    public function UpdatePass($newpass, $id)
    {
        $db = $this->dbConnect();
        $UpdatePass = $db->prepare('UPDATE members SET pass = ? WHERE id = ?');
        $UpdatePass->execute(array($newpass,$id));
    }
    
    
    public function checkLogIn($userName)
    {
        $db = $this->dbConnect();
        $check = $db->prepare('SELECT id, pass, group_id FROM members WHERE username = ?');
        $check->execute(array($userName));
        $checkLogIn = $check->fetch();
    
        return $checkLogIn;
    }
    
    //FIXME : factoriser avec la fonction checkLogIn ? 
    public function checkUsername($userName)
    {
        $db = $this->dbConnect();
        $check = $db->prepare('SELECT username FROM members WHERE username = ?');
        $check->execute(array($userName));
        $checkUsername = $check->fetch();
    
        return $checkUsername;
    }
    
    //FIXME : factoriser avec la fonction checkLogIn ? 
    public function checkEmail($email)
    {
        $db = $this->dbConnect();
        $check = $db->prepare('SELECT email FROM members WHERE email = ?');
        $check->execute(array($email));
        $checkEmail = $check->fetch();
    
        return $checkEmail;
    }
    
    //FIXME : factoriser avec la fonction checkLogIn ? 
    public function checkPass($userID)
    {
        $db = $this->dbConnect();
        $check = $db->prepare('SELECT pass FROM members WHERE id = ?');
        $check->execute(array($userID));
        $checkPass = $check->fetch();
    
        return $checkPass;
    }

}