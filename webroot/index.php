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

    $app->session->set('current_user', null);

    $app->flash->setInfoMessage('This application has been reset');
    $app->response->redirect($app->url->create('home'));
});




$app->router->add('home', function() use($app) {
    $app->theme->setTitle("Home");

    $app->views->add(
        'default/jumbotron',
        [
            'title'   => 'Silly Talk',
            'content' => "A place to discuss everything about football's silly season.",
        ],
        'jumbo_content'
    );
    $questions = $app->PostsController->posts->getLatestQuestions();
    $users = $app->UsersController->users->mostActiveUsers();
    $tags = $app->TagsController->tags->popularTags();

    $app->views->add(
        'default/toplists',
        [
            'toplist_questions' => $questions,
            'toplist_tags'      => $tags,
            'toplist_users'     => $users
        ],
        'toplists'
    );
});


$app->router->add('questions', function() use($app) {
    //$app->theme->setTitle("Questions");

    // TODO
    //     
    
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


$app->router->add('tags', function() use($app) {
    //$app->theme->setTitle("Questions");

    // TODO
    //     
    
    $app->dispatcher->forward(
        [
            'controller' => 'tags',
            'action'    =>  'list'
        ]
    );
});

$app->router->add('askQuestion', function() use($app) {
    $app->theme->setTitle("Ask Question");

    if($app->session->get('current_user') != null){
        $app->views->add(
            'posts/form-ask',
            [],
            'default_page'
        );        
    }else{ 
        $app->views->add(
            'default/jumbotron',
            [
                'title'   => 'You are not signed in',
                'content' => 'Please...',
            ],
            'jumbo_content'
        );
    }
    // TODO 
    //      Check if user is logged in
    //      Display log in or sign up
    //      
    //      Display form to ask question
});

$app->router->add('about', function() use($app) {
    $app->theme->setTitle("About");

    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add(
        'default/page', 
        [
            'title' =>  'About this page',
            'content' => $content,
        ],
        'default_page'
    ); 

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add(
        'default/page', 
        [
            'title' =>  'About me',
            'content' => $content,
        ],
        'default_page'
    ); 


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


