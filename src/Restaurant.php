<?php
    class Restaurant
    {
        private $name;
        private $cuisine_id;
        private $id;

        function __construct($name, $cuisine_id, $id = null)
        {
            $this->name = $name;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($name, $cuisine_id, $id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function find($search_id)
        {
            $found_name = null;
            $names = Restaurant::getAll();
            foreach($names as $name) {
                $name_id = $name->getId();
                if ($name_id == $search_id) {
                  $found_name = $name;
                }
            }
            return $found_name;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
        }

    }
?>
