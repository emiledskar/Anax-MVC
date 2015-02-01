<?php
namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{

	/**
	 * Method to seed the database with some default users.
	 */
	public function seed(){
		date_default_timezone_set('Europe/Stockholm');
	 	$now = date('y-m-d H:i:s');
	 	
	 	/* Adds a user */
	    $this->create([
	        'username' => 'test',
	        'email' => 'test@test.se',
	        'role' => 'user',
	        'password' => password_hash('test', PASSWORD_DEFAULT),
	        'created' => $now,
	    ]);

	   	/* Adds a user */
	    $this->create([
	        'username' => 'Kent',
	        'email' => 'kent@test.se',
	        'role' => 'user',
	        'password' => password_hash('kent', PASSWORD_DEFAULT),
	        'created' => $now,
	    ]);

	   	/* Adds a user */
	    $this->create([
	        'username' => 'Anna',
	        'email' => 'anna@test.se',
	        'role' => 'user',
	        'password' => password_hash('anna', PASSWORD_DEFAULT),
	        'created' => $now,
	    ]);

	   	/* Adds a user */
	    $this->create([
	        'username' => 'admin',
	        'email' => 'admin@admin.se',
	        'role' => 'admin',
	        'password' => password_hash('admin', PASSWORD_DEFAULT),
	        'created' => $now,
	    ]);
	}

	public function mostActiveUsers(){
		//select `username`, count(*) as occurrences
		//from anax_user
		// INNER JOIN anax_post ON anax_post.created_by_user = anax_user.id
		// group by `username`
		// ORDER BY occurrences DESC
		$this->query("anax_user.username, count(*) as occurrences, anax_user.id, anax_user.email, SUM(anax_post.points) as total_points","user")
	   		//->where('created_by_user = '.$this->session->get('current_user')->id )
		    ->join('post', 'anax_post.created_by_user = anax_user.id')
		    ->groupby('username')
		    ->limit(5)
		    ->orderby('total_points DESC');
		    
		return $this->execute();
	}
}