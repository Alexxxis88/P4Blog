<?php
    class User
    {
        private $_id ;
        private $_username ;
        private $_pass ;
        private $_email ;
        private $_modRegistrationDate ;
        private $_groupId ;
        private $_userComCount ;


        public function __construct(array $userDatas)
        {
            $this->hydrate($userDatas);
        }

        public function hydrate(array $userDatas)
        {
            foreach ($userDatas as $key => $value) {
                $method = 'set'.ucfirst($key);
                    
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }

        //GETTERS
        public function id()
        {
            return $this->_id;
        }
        public function username()
        {
            return $this->_username;
        }
        public function pass()
        {
            return $this->_pass;
        }
        public function email()
        {
            return $this->_email;
        }
        public function modRegistrationDate()
        {
            return $this->_modRegistrationDate;
        }
        public function groupId()
        {
            return $this->_groupId;
        }
        public function userComCount()
        {
            return $this->_userComCount;
        }


        //SETTERS
        public function setId($id)
        {
            $id = (int) $id;
    
            if ($id > 0) {
                $this->_id = $id;
            }
        }

        public function setUsername($username)
        {
            if (is_string($username)) {
                $this->_username = $username;
            }
        }
        
        public function setPass($pass)
        {
            if (is_string($pass)) {
                $this->_pass = $pass;
            }
        }

        public function setEmail($email)
        {
            if (is_string($email)) {
                $this->_email = $email;
            }
        }

        public function setModRegistrationDate($modRegistrationDate)
        {
            $this->_modRegistrationDate = $modRegistrationDate;
        }

        public function setGroupId($groupId)
        {
            $groupId = (int) $groupId;
    
            if ($groupId >= 0) {
                $this->_groupId = $groupId;
            }
        }

        public function setCommentCount($userComCount)
        {
            $userComCount = (int) $userComCount;
    
            if ($userComCount >= 0) {
                $this->_userComCount = $userComCount;
            }
        }
    }
