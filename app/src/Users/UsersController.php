<?php
namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

	/**
	 * Initialize the controller.
	 * Körs innan alla action anrop?!
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	}



	/**
	 * Skapa tabell och ett par användare.
	 *
	 * @return void
	 */
	public function setupAction(){
		$this->db->dropTableIfExists('user')->execute();
	 
	    $this->db->createTable(
	        'user',
	        [
	            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
	            'username' => ['varchar(20)', 'unique', 'not null'],
	            'email' => ['varchar(80)'],
	            'role' => ['varchar(20)'],
	            'password' => ['varchar(255)'],
	            'created' => ['datetime']
	        ]
	    )->execute();

		$this->users->seed();
	}



    /**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAction()
	{
	    $all = $this->users->findAll();
	 	
	    $this->theme->setTitle('Users');
	    $this->views->add(
	    	'users/list-all',
	    	[
	        	'users' => $all,
	        	'title' => 'Users'
	    	],
	    	'default_page'
	    );
	}



	/**
	 * List user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
		if (!isset($id)) {
	        die("Missing id");
	    }
	    $user = $this->users->find($id);

	    //SELECT anax_post.title, anax_post.content, anax_user.username FROM anax_post INNER JOIN anax_user ON anax_post.created_by_user = anax_user.id WHERE anax_post.parent_post IS NULL
	   
	    ///*************
	    ///
	    ///
	    ///
	    /// HERE IS HOW JOIN WORKS!!!!!
	    ///
	    ///
	    /// print_r($questions);
	    ///
	   $this->db->select("anax_post.id, anax_post.title, anax_post.content, anax_post.points, anax_user.username")
	   		->from('post')
	   		->where('created_by_user = '.$user->id )
		    ->andWhere('parent_post IS NULL')
		    ->join('user', 'anax_post.created_by_user = anax_user.id');
		    
		$questions = $this->db->executeFetchAll();


		$this->db->select("anax_post.id, anax_post.title, anax_post.content, anax_post.points, anax_post.parent_post, anax_user.username")
	   		->from('post')
	   		->where('created_by_user = '.$user->id )
		    ->andWhere('parent_post IS NOT NULL')
		    ->andWhere('anax_post.is_answer IS NOT NULL')
		    ->join('user', 'anax_post.created_by_user = anax_user.id');
		    
		$answers = $this->db->executeFetchAll();


		$this->db->select("anax_post.id, anax_post.title, anax_post.content, anax_post.parent_post, anax_user.username")
	   		->from('post')
	   		->where('created_by_user = '.$user->id )
		    ->andWhere('parent_post IS NOT NULL')
		    ->andWhere('anax_post.is_answer IS NULL')
		    ->join('user', 'anax_post.created_by_user = anax_user.id');
		    
		$comments = $this->db->executeFetchAll();
	     	
	    /*$questions = $this->posts->query()
	    	->where('created_by_user = '.$user->id )
	    	->andWhere('parent_post IS NULL')
	    	->execute();*/
	 	
	 	//var_dump($questions_1);
	 	//echo $this->db->getSQL();
	    //echo $questions_1[0];
	    //var_dump($questions);


	 	/*$answers = $this->posts->query()
	    	->where('created_by_user = '.$user->id )
	    	->andWhere('parent_post IS NOT NULL')
	    	->execute();*/

	    $this->theme->setTitle("View user with id");
	    $this->views->add(
	    	'users/profile',
	    	[
	        	'user' => $user,
	        	'questions' => $questions,
	        	'answers' => $answers,
	        	'comments' => $comments
	    	],
	    	'default_page'
	    );
	}
 

	/**
	 * Add new user.
	 *
	 * @param string $acronym of user to add.
	 *
	 * @return void
	 */
	public function addAction($name = null, $email = null, $acronym = null)
	{
	    if (!isset($name) || !isset($email) || !isset($acronym)) {
	        die("Missing arguments");
	    }

	 	date_default_timezone_set('Europe/Stockholm');
	 	$now = date('y-m-d H:i:s');
	
	    $this->users->save([
	        'acronym' => $acronym,
	        'email' => $email,
	        'name' => $name,
	        'password' => password_hash($acronym, PASSWORD_DEFAULT),
	        'created' => $now,
	        'active' => $now,
	    ]);

	    $url = $this->url->create('users/id/' . $this->users->id);
	    $this->response->redirect($url);
	}

	/**
	 * Delete user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }

	    $res = $this->users->delete($id);
	
	    $url = $this->url->create('users/list');
	    $this->response->redirect($url);
	}

	/**
	 * Delete (soft) user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function softDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	 	date_default_timezone_set('Europe/Stockholm');
	 	$now = date('y-m-d H:i:s');
	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = $now;
	    $user->active = null;
	    $user->save();
	 
	 	//echo $this->request->getBaseUrl();
	    $url = $this->url->create('users/list');
	    $this->response->redirect($url);
	}


	/**
	 * Delete (soft) user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function undoSoftDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }

	   	date_default_timezone_set('Europe/Stockholm');
	 	$now = date('y-m-d H:i:s');
	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = null;
	    $user->active = $now;
	    $user->save();
	 
	    $url = $this->url->create('users/list');
	    $this->response->redirect($url);
	}


	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function listActiveAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NOT NULL')
	        ->andWhere('deleted is NULL')
	        ->orderBy('ID ASC')
	        ->execute();
		
	    $this->theme->setTitle("Users that are active");
	    $this->views->add(
	    	'users/list-all', 
	    	[
	        	'users' => $all,
	        	'title' => "Users that are active",
	    	]
	    );
	}



	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function listInActiveAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NULL')
	        ->andWhere('deleted is NULL')
	        ->orderBy('ID ASC')
	        ->execute();
	 
	    $this->theme->setTitle("Inactive users");
	    $this->views->add(
	    	'users/list-all', 
	    	[
	        	'users' => $all,
	        	'title' => "Users that are inactive",
	    	]
	    );
	}



		/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function listSoftDeletedAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NULL')
	        ->andWhere('deleted is NOT NULL')
	        ->orderBy('ID ASC')
	        ->execute();
	 
	    $this->theme->setTitle("Trashcan");
	    $this->views->add(
	    	'users/list-all', 
	    	[
	        	'users' => $all,
	        	'title' => "Users in trashcan",
	    	]
	    );
	}



	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function activateUserAction($id = null){
	    if (!isset($id)) {
	        die("Missing id");
	    }

	    $user = $this->users->find($id);

	    if($user->active)
	    	$user->active = null;
	    else{
	    	date_default_timezone_set('Europe/Stockholm');
	 		$now = date('y-m-d H:i:s');
	    	$user->active = $now;
	    }

		$user->save();

		$url = $this->url->create('users/list');
	    $this->response->redirect($url);
	}



	/**
	 * Redirects to the update screen.
	 *
	 * @return void
	 */
	public function updateAction($id){
		
		if (!isset($id)) {
	        die("Missing id");
	    }

	    $user = $this->users->find($id);

	    if( $_POST['username'] != null){
	    	$user->username = $_POST['username'];
	    }

	    if( $_POST['email'] != null){
	    	$user->email = $_POST['email'];
	    }

	    if( $_POST['password'] != null){
	    	$this->users->save(
				[
					'id' => $id, 
					'username' => $user->username,
		        	'email' => $user->email,
		        	'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
		        ]
			);
	    }else{
	    	$this->users->save(
				[
					'id' => $id, 
					'username' => $user->username,
		        	'email' => $user->email,
		        ]
			);

	    }
		$user = $this->users->query()
	        	->where('id = '.$id)
	        	->execute(true);
		//print_r($user);
	   	$this->session->set('current_user', $user );

		$this->flash->setSuccessMessage('Your profile was updated');
    	$url = $this->url->create('users/settings');
		$this->response->redirect($url);  	
	}



	public function loginAction(){
		if (empty($_POST)){
			$this->views->add(
				'users/login',
				[],
				'default_page'
			);
		}else{
			$username =  $_POST['username'];
			$password = $_POST['password'];
			$user = $this->users->query()
	        	->where('username = "'.$username.'"')
	        	->execute();

	        if( $user && password_verify($password,$user[0]->password) ){
	       		$this->session->set('current_user', $user[0]);
	       		$this->flash->setSuccessMessage('Signed in!');
	       		$url = $this->url->create('home');
	    		$this->response->redirect($url);
	        }else{
	        	$this->flash->setErrorMessage('Could not log in');
	        	$this->response->redirect($this->url->create('users/login'));
	        }
		}
	}

	public function logoutAction(){
		$this->session->set('current_user', null);
		$this->flash->setInfoMessage('Signed out!');
		$url = $this->url->create('home');
	    $this->response->redirect($url);

	}


	//Not tested
	public function registerAction(){
		if (empty($_POST)){
			$this->views->add(
				'users/register',
				[],
				'default_page'
			);
		}else{
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			
			date_default_timezone_set('Europe/Stockholm');
	 		$now = date('y-m-d H:i:s');

		    $success = $this->users->create([
		        'username' => $username,
		        'email' => $email,
		        'role' => 'user',
		        'password' => password_hash($password, PASSWORD_DEFAULT),
		        'created' => $now
		    ]);

		    if($success){
		    	$this->flash->setSuccessMessage('User created, please sign in');
		    	$url = $this->url->create('users/login');
	    		$this->response->redirect($url);
		    }else{
		    	$this->flash->setErrorMessage('Something went wron, please try again');
		    	$url = $this->url->create('users/register');
	    		$this->response->redirect($url);
		    }
		}
	}

	public function settingsAction(){

		$this->views->add(
			'users/settings-form',
			[
				'user' => $this->session->get('current_user')
			],
			'default_page'
		);
	}
}