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


        require_once("api/".$prefix.".php");


    });
}


require_once("vendor/autoload.php");


use Slim\Factory\AppFactory;



$app = AppFactory::create();


$app->addRoutingMiddleware();

$app->addErrorMiddleware(false, true, true);




$app->run();

?>
