<?php
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Restaurant.php';
    require_once __DIR__.'/../src/Cuisine.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=eating';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {

    return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisine", function() use ($app) {
        $type = $_POST['type'];
        $cuisine = new Cuisine($type, $id = null);
        $cuisine->save();
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine));
    });

    $app->post("/restaurant", function() use ($app) {
         $name = $_POST['new_restaurant'];
         $cuisine_id = $_POST['cuisine_id'];
         $cuisine = Cuisine::find($cuisine_id);
         $restaurant = new Restaurant($name, $cuisine_id, $id = null);
         $restaurant->save();
         return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine, 'restaurants' => Restaurant::getAll()));
    });

    $app->get("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->get("/cuisine/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $restaurants = Restaurant::getAll();
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine, 'restaurants' => $restaurants));
    });

    $app->patch("/cuisine/{id}", function($id) use ($app) {
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($type);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine));
    });

    $app->delete("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->delete();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurant/{id}/edit", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        //$restaurant = Restaurant::getAll();
        return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant));
    });

    $app->patch("/restaurant/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $cuisines = Cuisine::getAll();
        // $restaurants = Restaurant::getAll();
        $restaurant = Restaurant::find($id);
        $restaurant->update($name);
        $cuisine_id = $restaurant->getCuisineId();





        // return $app['twig']->render('index.html.twig', array('cuisines' => $cuisines, 'restaurant' => $restaurant));


        return $app->redirect("/cuisine/".$cuisine_id."/edit");
    });

    $app->delete("/restaurant/{id}", function($id) use ($app) {
        $cuisines = Cuisine::getAll();
        $restaurant = Restaurant::find($id);
        $restaurant->delete();
        return $app['twig']->render('index.html.twig', array('cuisines' => $cuisines, 'restaurant' => $restaurant));
    });

    return $app;

?>
