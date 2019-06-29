<?php
class UserManager extends Manager
{
    public function getAllUsers($firstUser, $usersPerPage)
    {
        $req = $this->_db->prepare('SELECT id, username, email, DATE_FORMAT(registrationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS modRegistrationDate, groupId FROM members ORDER BY username LIMIT ?,?');
        $req->bindValue(1, $firstUser, PDO::PARAM_INT);
        $req->bindValue(2, $usersPerPage, PDO::PARAM_INT);
        $req->execute();

        while ($userDatas = $req->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($userDatas);
        }
        if (!empty($users)) { //needed otherwise gives an error on the usersView.php when no users in DB
            return $users;
        }
    }

    //Pagination
    public function getTotalPagesUsers()
    {
        $req = $this->_db->query('SELECT COUNT(*) AS total_users FROM members');
        $returnTotalPagesUsers= $req->fetch();
        return $returnTotalPagesUsers;
    }

    public function eraseUser($userId)
    {
        $req = $this->_db->prepare('DELETE FROM members WHERE id = ?');
        $req->execute(array($userId));
    }

    public function eraseAllSelectedUsers($arrayUsersIDs)
    {//must receive an array of ids to delete all the users at once.
        $arrayLength = count($arrayUsersIDs, COUNT_NORMAL);
        //loop needed to add each int entry of $arrayUsersIDs as a (?) paramater for IN
        for ($i = 0; $i < $arrayLength; $i++) {
            $id = $arrayUsersIDs[$i];
            $req = $this->_db->prepare('DELETE FROM members WHERE id IN (?)');
            $req->execute(array($id));
        }
    }

    public function updateRole($userRole, $userId)
    {
        $req = $this->_db->prepare('UPDATE members SET groupId = ? WHERE id = ?');
        $req->execute(array($userRole, $userId));
    }
}
