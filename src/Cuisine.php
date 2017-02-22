<?php
    class Cuisine
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function getType()
        {
            return $this->type;
        }

        function getId()
        {
            return $this->id;
        }

        function setType($new_type)
        {
            $this->type = (string) $new_type;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (type) VALUES ('{$this->getType()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine) {
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }
        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }

        function update($new_type)
        {
            $GLOBALS['DB']->exec("UPDATE cuisine SET type = '{$new_type}' WHERE id = {$this->getId()};");
            $this->setType($new_type);
        }

        // function getTasks()
        // {
        //     $tasks = Array();
        //     $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks WHERE category_id = {$this->getId()};");
        //     foreach($returned_tasks as $task) {
        //         $description = $task['description'];
        //         $id = $task['id'];
        //         $category_id = $task['category_id'];
        //         $new_task = new Task($description, $id, $category_id);
        //         array_push($tasks, $new_task);
        //     }
        //     return $tasks;
        // }
    }
?>
