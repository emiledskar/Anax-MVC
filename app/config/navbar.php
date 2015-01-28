<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create('home'),
            'title' => 'Home',
        ],
 
        // This is a menu item
        'questions' => [
            'text'  =>'Questions',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'Questions'
        ],

        // This is a menu item
        'users' => [
            'text'  =>'Users',
            'url'   => $this->di->get('url')->create('users'),
            'title' => 'Users'
        ],

        // This is a menu item
        'askQuestion' => [
            'text'  =>'Ask Question',
            'url'   => $this->di->get('url')->create('askQuestion'),
            'title' => 'Ask Question'
        ],        

        // This is a menu item
        'login' => [
            'text'  =>'Login',
            'url'   => $this->di->get('url')->create('users/login'),
            'title' => 'Login'
        ],

        // This is a menu item
        'logout' => [
            'text'  =>'Logout',
            'url'   => $this->di->get('url')->create('users/logout'),
            'title' => 'Logout',
        ],
        
        // This is a menu item
        'about' => [
            'text'  =>'About',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'About'
        ],
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($this->di->get('request')->getCurrentUrl($url) == $this->di->get('url')->create($url)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
