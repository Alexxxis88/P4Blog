<?php
    class Post
    {
        private $_id ;
        private $_chapterNb ;
        private $_title ;
        private $_content ;
        private $_modPublishDate ;
        private $_modEditDate ;
        private $_commentCount ;


        public function __construct(array $datas)
        {
            $this->hydrate($datas);
        }

        public function hydrate(array $datas) // ne fonctionne pas avec les champs qui ont un tiret au milieu
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
        public function chapterNb()
        {
            return $this->_chapterNb;
        }
        public function title()
        {
            return $this->_title;
        }
        public function content()
        {
            return $this->_content;
        }
        public function modPublishDate()
        {
            return $this->_modPublishDate;
        }
        public function modEditDate()
        {
            return $this->_modEditDate;
        }
        public function commentCount()
        {
            return $this->_commentCount;
        }


        //SETTERS
        public function setId($id)
        {
            $id = (int) $id;
    
            if ($id > 0) {
                $this->_id = $id;
            }
        }

        public function setChapterNb($chapterNb)
        {
            if (is_string($chapterNb)) {
                $this->_chapterNb = $chapterNb;
            }
        }
        
        public function setTitle($title)
        {
            if (is_string($title)) {
                $this->_title = $title;
            }
        }

        public function setContent($content)
        {
            if (is_string($content)) {
                $this->_content = $content;
            }
        }

        public function setModPublishDate($modPublishDate)
        {
            $this->_modPublishDate = $modPublishDate;
        }

        public function setModEditDate($modEditDate)
        {
            $this->_modEditDate = $modEditDate;
        }

        public function setCommentCount($commentCount)
        {
            $commentCount = (int) $commentCount;
    
            if ($commentCount >= 0) {
                $this->_commentCount = $commentCount;
            }
        }
    }
