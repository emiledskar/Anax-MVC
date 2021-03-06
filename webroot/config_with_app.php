<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

//$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
//$app->theme->configure(ANAX_APP_PATH . 'config/theme.php');
// $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->session();

// shared variables
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->set('UsersController', function() use($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});
$app->UsersController->initialize();

$di->set('PostsController', function() use($di) {
    $controller = new \Anax\Posts\PostsController();
    $controller->setDI($di);
    return $controller;
});
$app->PostsController->initialize();

$di->set('TagsController', function() use($di) {
    $controller = new \Anax\Tags\TagsController();
    $controller->setDI($di);
    return $controller;
});
$app->TagsController->initialize();