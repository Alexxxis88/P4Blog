<?php
class UserManager extends Manager
{

    public function getAllUsers()
    {
        $req = $this->_db->query('SELECT id, username, email, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modRegistrationDate, groupId FROM members ORDER BY username LIMIT 0, 50');
        
        while ($userDatas = $req->fetch(PDO::FETCH_ASSOC))
        {           
            $users[] = new User($userDatas);
        }
        
        return $users;
    }

    public function eraseUser($userId)
    {
        $req = $this->_db->prepare('DELETE FROM members WHERE id = ?');
        $req->execute(array($userId));
    }

    //must receive an array of ids to delete all the users at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
    public function eraseAllSelectedUsers($arrayUsersIDs) //NOT WORKING :
    {
        //on compte la longueur du tableau pour arrêter la boucle for au bon moment
        $arrayLength = count($arrayUsersIDs, COUNT_NORMAL);
        
        //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayUsersIDs en tant que paramètre ? de (IN)
        for( $i = 0; $i < $arrayLength; $i++){
            $id = $arrayUsersIDs[$i];
            $req = $this->_db->prepare('DELETE FROM members WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
            $req->execute(array($id));
        }
    }

    public function updateRole($userRole, $userId)
    {
        $req = $this->_db->prepare('UPDATE members SET groupId = ? WHERE id = ?');
        $req->execute(array($userRole, $userId));
    }

}