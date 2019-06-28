<?php
    class Comment
    {
        private $_id ;
        private $_postId ;
        private $_author ;
        private $_comment ;
        private $_modCommentDate ;
        private $_modUpdateDate ;
        private $_flag ;


        public function __construct(array $datas)
        {
            $this->hydrate($datas);
        }

        public function hydrate(array $datas) // ne fonctionne pas avec les champs qui ont une Majuscule au milieu
        {
            foreach ($datas as $key => $value) {
                // On récupère le nom du setter correspondant à l'attribut.
                $method = 'set'.ucfirst($key);
                    
                // Si le setter correspondant existe.
                if (method_exists($this, $method)) {
                    // On appelle le setter.
                    $this->$method($value);
                }
            }
        }

        //GETTERS
        public function id()
        {
            return $this->_id;
        }
        public function postId()
        {
            return $this->_postId;
        }
        public function author()
        {
            return $this->_author;
        }
        public function comment()
        {
            return $this->_comment;
        }
        public function modCommentDate()
        {
            return $this->_modCommentDate;
        }
        public function modUpdateDate()
        {
            return $this->_modUpdateDate;
        }
        public function flag()
        {
            return $this->_flag;
        }


        //SETTERS
        public function setId($id)
        {
            $id = (int) $id;
    
            if ($id > 0) {
                $this->_id = $id;
            }
        }

        public function setPostId($postId)
        {
            $postId = (int) $postId;
    
            if ($postId > 0) {
                $this->_postId = $postId;
            }
        }
        
        public function setAuthor($author)
        {
            if (is_string($author)) {
                $this->_author = $author;
            }
        }

        public function setComment($comment)
        {
            if (is_string($comment)) {
                $this->_comment = $comment;
            }
        }

        public function setModCommentDate($modCommentDate)
        {
            $this->_modCommentDate = $modCommentDate;
        }

        public function setModUpdateDate($modUpdateDate)
        {
            $this->_modUpdateDate = $modUpdateDate;
        }

        public function setFlag($flag)
        {
            $flag = (int) $flag;
    
            if ($flag >= 0) {
                $this->_flag = $flag;
            }
        }
    }
