<?php
class SessionManager extends Manager
{
    public function insertMember($username, $pass, $email)
    {
        $newMember = $this->_db->prepare('INSERT INTO members( username, pass, email, registrationDate) VALUES(?, ?, ?, NOW())');
        $newMember->execute(array($username, $pass, $email));
    }

    public function UpdatePass($newpass, $id)
    {
        $UpdatePass = $this->_db->prepare('UPDATE members SET pass = ? WHERE id = ?');
        $UpdatePass->execute(array($newpass,$id));
    }

    public function checkLogIn($userName)
    {
        $check = $this->_db->prepare('SELECT id, pass, groupId FROM members WHERE username = ?');
        $check->execute(array($userName));
        $checkLogIn = $check->fetch();
        return $checkLogIn;
    }

    public function checkRole($userID)
    {
        $req = $this->_db->prepare('SELECT groupId FROM members WHERE id = ?');
        $req->execute(array($userID));
        $checkRole = $req->fetch();
        return $checkRole;
    }

    public function checkUsername($userName)
    {
        $check = $this->_db->prepare('SELECT username FROM members WHERE username = ?');
        $check->execute(array($userName));
        $checkUsername = $check->fetch();
        return $checkUsername;
    }

    public function checkEmail($email)
    {
        $check = $this->_db->prepare('SELECT email FROM members WHERE email = ?');
        $check->execute(array($email));
        $checkEmail = $check->fetch();
        return $checkEmail;
    }

    public function checkPass($userID)
    {
        $check = $this->_db->prepare('SELECT pass FROM members WHERE id = ?');
        $check->execute(array($userID));
        $checkPass = $check->fetch();
        return $checkPass;
    }
}
