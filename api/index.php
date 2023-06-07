<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Credentials: true");


function loader() : void
{
    spl_autoload_register(function($class){

        $prefix = str_replace("\\", DIRECTORY_SEPARATOR, $class);


        require_once($prefix.".php");


    });
}


require_once("vendor/autoload.php");


use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;



$app = AppFactory::create();


$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, true, true);


$app->post('/api/act', function () {

    loader();

   new controller\User_Controller();
     
});

$app->put('/api/act', function () {

    loader();

   new controller\User_Controller();
     
});

$app->delete('/api/act', function () {

    loader();

   new controller\User_Controller();
     
});

$app->get('/api/act/{menuop}', function (Request $request) {

    loader();

    $menuop = is_string($request->getAttribute('menuop')) ? htmlspecialchars($request->getAttribute('menuop')) : null;

    new controller\User_Controller($menuop);
     
});

$app->get('/api/act/', function () {

    loader();

    new controller\User_Controller();
     
});



$app->run();

?>
