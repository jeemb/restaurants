<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost:8889;dbname=eating_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Restaurant";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);
            $test_restaurant->save();
            //Act
            $result = $test_restaurant->getId();
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getCuisineId()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Restaurant";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);
            $test_restaurant->save();
            //Act
            $result = $test_restaurant->getCuisineId();
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Restaurant";
            $id = null;
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);

            //Act
            $test_restaurant->save();

            //Assert
            $result = Restaurant::getAll();
            var_dump($result);
            $this->assertEquals($test_restaurant, $result[0]);

        }

        function test_deleteAll()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Restaurant";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);

            //Act
            Restaurant::deleteAll();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Restaurant";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);
            $test_restaurant->save();

            //Act
            $result = Restaurant::find($test_restaurant->getId());

            //Assert
            $this->assertEquals($test_restaurant, $result);
        }

        function test_setName()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "restaurant";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);
            $test_restaurant->save();

            $new_name = "new restaurant";

            //Act
            $test_restaurant->setName($new_name);

            //Assert
            $this->assertEquals("new restaurant", $test_restaurant->getName());
        }

        function testUpdate()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "restaurant";
            $cuisine_id = $test_cuisine->getId();
            $id = null;
            $test_restaurant = new Restaurant($name, $cuisine_id, $id);
            $test_restaurant->save();

            $new_name = "new restaurant";

            //Act
            $test_restaurant->update($new_name);

            //Assert
            $this->assertEquals("new restaurant", $test_restaurant->getName());
        }

    }
?>
