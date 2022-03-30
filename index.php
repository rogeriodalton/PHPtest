<?php

use CoffeeCode\Router\Router;

require __DIR__ . "/vendor/autoload.php";

$router = new Router(ROOT);
$router->namespace("Source\Controllers");

$router->group(null);
$router->get("/", "Form:home", "form.home"); 
$router->post("/create", "Form:Create", "form.create"); 
$router->post("/delete", "Form:Delete", "form.delete");

$router->dispatch();

if ($router->error()) {
    //$router->redirect("/ooops/{$router->error()}");
    var_dump($router->error());
}