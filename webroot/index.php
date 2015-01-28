<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


$app->router->add('setup', function() use ($app) {
    
    $app->dispatcher->forward(
        [
          'controller' => 'users',
          'action'     => 'setup'
        ]
    );

    $app->dispatcher->forward(
        [
          'controller' => 'posts',
          'action'     => 'setup'
        ]
    );

});




$app->router->add('home', function() use($app) {
    $app->theme->setTitle("Home");

    $app->views->add(
        'default/jumbotron',
        [
            'title'   => 'Test title',
            'content' => 'Test',
        ],
        'jumbo_content'
    );

    $app->views->add(
        'default/toplists',
        [
            'toplist_questions' => array("test"),
            'toplist_users'     => array( array('name' => 'test', 'points' => 900), array('name' => 'test2', 'points' => 999) ),
            'toplist_tags'      => array("test2")
        ],
        'toplists'
    );
});

$app->router->add('questions', function() use($app) {
    $app->theme->setTitle("Questions");

    // TODO
    //      List questions
    
    $app->dispatcher->forward(
        [
            'controller' => 'posts',
            'action'    =>  'list'
        ]
    );
});

$app->router->add('users', function() use($app) {
    $app->theme->setTitle("Users");

    // TODO 
    //      List users
    $app->dispatcher->forward(
        [
          'controller' => 'users',
          'action'     => 'list'
        ]
    );
});

$app->router->add('askQuestion', function() use($app) {
    $app->theme->setTitle("Ask Question");


    $app->views->add(
        'posts/form',
        [],
        'default_page'
    );
    // TODO 
    //      Check if user is logged in
    //      Display log in or sign up
    //      
    //      Display form to ask question
});

$app->router->add('about', function() use($app) {
    $app->theme->setTitle("About");

    $app->theme->addStylesheet('css/source.css');

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add(
        'default/page', 
        [
            'title' =>  'Source',
            'content' => $source->View(),
        ],
        'default_page'
    ); 
});

// Render the response using theme engine.
$app->router->handle();
$app->theme->render();


