<?php

class SessionController
{
    public function checkSession()
    {
        //we check wether the member is registered with COOKIE or SESSION
        if (isset($_COOKIE['id'])) {
            $cookieOrSessionID = $_COOKIE['id'];
            return $cookieOrSessionID;
        } elseif (isset($_SESSION['id'])) {
            $cookieOrSessionID = $_SESSION['id'];
            return $cookieOrSessionID;
        }
    }

    //check the role of the logged in user to display or not Admin features
    public function checkUserRole()
    {
        if (isset($_COOKIE['id'])) {
            $cookieOrSessionID = $_COOKIE['id'];
            $sessionManager = new SessionManager;
            $checkRole = $sessionManager->checkRole($cookieOrSessionID);
            return $checkRole;
        } elseif (isset($_SESSION['id'])) {
            $cookieOrSessionID = $_SESSION['id'];
            $sessionManager = new SessionManager;
            $checkRole = $sessionManager->checkRole($cookieOrSessionID);
            return $checkRole;
        }
    }

    public function addNewMember($username, $pass, $email)
    {
        $sessionManager = new SessionManager();
        $newMember = $sessionManager->insertMember(htmlspecialchars($username), htmlspecialchars($pass), htmlspecialchars($email));

        header('Location: index.php?success=1#header');
        exit;
    }


    public function checkUsernameAvailability($userName)
    {
        $sessionManager = new SessionManager();
        $checkUsername = $sessionManager->checkUsername($userName);
        if ($checkUsername) {
            return true;
        } else {
            return false;
        }
    }

    public function checkEmailAvailability($email)
    {
        $sessionManager = new SessionManager();
        $checkEmail = $sessionManager->checkEmail($email);
        if ($checkEmail) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLog($userName)
    {
        $sessionManager = new SessionManager();
        $checkLogIn = $sessionManager->checkLogIn($userName);

        // Check is password matches the one registered in DB
        $isPasswordCorrect = password_verify(htmlspecialchars($_POST['pass']), $checkLogIn['pass']);
        if (!$checkLogIn) {
            throw new Exception('Vérifiez vos identifiants de connexion');
        } else {   //if the password is Correct SESSION variables are created
            if ($isPasswordCorrect) {
                $_SESSION['id'] = $checkLogIn['id'];
                $_SESSION['username'] = $userName;

                //if the autolog checkbox is selected COOKIES are created
                if (isset($_POST['autoLogIn'])) {
                    setcookie('id', $checkLogIn['id'], time() + 365*24*3600, null, null, false, true);
                    setcookie('login', htmlspecialchars($_POST['username']), time() + 365*24*3600, null, null, false, true);
                    setcookie('hash_pass', password_hash($_POST['pass'], PASSWORD_DEFAULT), time() + 365*24*3600, null, null, false, true);
                }

                header('Location: index.php');
                exit;
            } else {
                throw new Exception('Vérifiez vos identifiants de connexion');
            }
        }
    }


    public function UpdatePassWord($newpass, $id)
    {
        $sessionManager = new SessionManager();
        $UpdatePassWord = $sessionManager->UpdatePass(htmlspecialchars($newpass), $id);
    }

    public function checkCurrentPass($userID)
    {
        $sessionManager = new SessionManager();
        $checkCurrentPass = $sessionManager->checkPass($userID);
        $isPasswordCorrect = password_verify($_POST['currentPass'], $checkCurrentPass['pass']);

        if ($isPasswordCorrect) {
            return true;
        } else {
            return false;
        }
    }

    public function killSession()
    {
        // Delete session variables
        $_SESSION = array();
        session_destroy();
        // Delete autologing cookies
        setcookie('id', '', time() + 365*24*3600, null, null, false, true);
        setcookie('login', '', time() + 365*24*3600, null, null, false, true);
        setcookie('hash_pass', '', time() + 365*24*3600, null, null, false, true);
    }
}
