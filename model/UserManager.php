<?php
class UserManager
{
    //gets all the users
    public function getAllUsers($firstUser, $usersPerPage)
    {
        $db = $this->dbConnect();
        $allUsers = $db->prepare('SELECT id, username, email, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS mod_registration_date, group_id FROM members ORDER BY username LIMIT ?, ?');
        $allUsers->bindValue(1, $firstUser, PDO::PARAM_INT);
        $allUsers->bindValue(2, $usersPerPage, PDO::PARAM_INT);
        $allUsers->execute();
        return $allUsers;
    }


    //Pagination
    public function getTotalPagesUsers(){
        $db = $this->dbConnect();
        $getTotalPagesUsers = $db->query('SELECT COUNT(*) AS total_users FROM members');
        $returnTotalPagesUsers= $getTotalPagesUsers->fetch();

        return $returnTotalPagesUsers;
    }


    //must receive an array of ids to delete all the users at once. (?) = my array, see here https://www.tutorialspoint.com/mysql/mysql-in-clause.htm
    public function eraseAllSelectedUsers($arrayUsersIDs) //NOT WORKING :
    {
        //on compte la longueur du tableau pour arrêter la boucle for au bon moment
        $arrayLength = count($arrayUsersIDs, COUNT_NORMAL);
        
        //on fait une boucle pour injecter la VALEUR ENTIERE de chaque entrée du tableau $arrayUsersIDs en tant que paramètre ? de (IN)
        for( $i = 0; $i < $arrayLength; $i++){
            $id = $arrayUsersIDs[$i];
            $db = $this->dbConnect();
            $eraseAllSelectedUsers = $db->prepare('DELETE FROM members WHERE id IN (?)'); // je veux que ? soit les valeurs successives d'un tableau donc je dois faire une boucle
            $eraseAllSelectedUsers->execute(array($id));
        }
        
    }


    public function eraseUser($userId)
    {
        $db = $this->dbConnect();
        $useDelete = $db->prepare('DELETE FROM members WHERE id = ?');
        $useDelete->execute(array($userId));
    }


    public function updateRole($userRole, $userId)
    {
        $db = $this->dbConnect();
        $userUpdate = $db->prepare('UPDATE members SET group_id = ? WHERE id = ?');
        $userUpdate->execute(array($userRole, $userId));
    }





   // General public function to connect to database
    private function dbConnect()
    {
        $db = new PDO('mysql:host=localhost;dbname=p4blog;charset=utf8', 'root', '');
        return $db;
    }

}