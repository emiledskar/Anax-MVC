<?php
namespace Anax\Posts;
 
/**
 * A controller for users and admin related events.
 *
 */
class PostsController implements \Anax\DI\IInjectionAware
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
		$this->posts = new \Anax\Posts\Post();
	    $this->posts->setDI($this->di);
	}



	/**
	 * Skapa tabell och ett par användare.
	 *
	 * @return void
	 */
	public function setupAction(){

	    $this->db->dropTableIfExists('post')->execute();
	    $this->db->createTable(
	        'post',
	        [
	            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
	            'title' => ['varchar(255)'],
	            'content' => ['mediumtext'],
	            'created_by_user' => ['integer', 'not null'],
	            'parent_post' => ['integer'],
	            'is_answer' => ['boolean'],
	            'points' => ['integer'],
	            'created' => ['datetime'],
	            'modified' => ['datetime']
	        ]
	    )->execute();

	    $this->db->dropTableIfExists('postDetails')->execute();
	    $this->db->createTable(
	        'postDetails',
	        [
	            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
	            'post_id' => ['integer', 'not null'],
	            'tag_id' => ['integer', 'not null']
	        ]
	    )->execute();

	    $this->db->dropTableIfExists('tags')->execute();
	    $this->db->createTable(
	        'tags',
	        [
	            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
	            'name' => ['varchar(255)'],
	            'created' => ['datetime']
	        ]
	    )->execute();

		$this->posts->seed();

	 	/*$url = $this->url->create('users/list');
	    $this->response->redirect($url);*/

	}



    /**
	 * List all posts.
	 *
	 * @return void
	 */
	public function listAction()
	{
	    //$all = $this->posts->findAll();
	    //
	    //Method to fetch posts, their creator and their tags
	    $posts = $this->posts->populatePosts();

	    //print_r($all);
	    /*$all = $this->posts->query()
	        ->where('parent_post IS NULL')
	       	->execute();
	    
	    $all = $this->posts->populatePosts($all);*/
	    //$all = $all->getProperties();

	 	
	    // var_dump($all);
	    // var_dump($all_modified);
	    $this->theme->setTitle('Questions');
	    $this->views->add(
	    	'posts/list-all',
	    	[
	        	'posts' => $posts,
	        	'title' => 'Questions',
	    	],
	    	'default_page'
	    );
	}



	/**
	 * List question with id.
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
	    /*$posts = $this->posts->query()
	        ->where('id = '.$id)
	       	->execute();
	    $posts = $this->posts->populatePosts($posts);*/
	    
	    //$posts = $this->posts->populateSinglePost($id);

	   	$post = $this->posts->query("anax_post.*, anax_user.username, anax_user.email, anax_user.id as user_id", "post")
			   		->where('anax_post.id = '.$id)
				    ->join('user', 'anax_post.created_by_user = anax_user.id')
				    ->execute(true);

	    //print_r($post);


	    $answers = $this->posts->query("anax_post.*, anax_user.username, anax_user.email, anax_user.id as user_id", "post")
			   		->where('anax_post.parent_post = '.$id)
			   		->andWhere('anax_post.is_answer IS NOT NULL')
				    ->leftJoin('user', 'anax_post.created_by_user = anax_user.id')
				    ->execute();

		foreach ($answers as $answer) {
			$answer->comments = $this->posts->query("*, anax_user.username, anax_user.email, anax_user.id as user_id ","post")
				->where('anax_post.parent_post = '. $answer->id)
				->join('user', 'anax_post.created_by_user = anax_user.id')
				->execute();
		}


	    $comments = $this->posts->query("anax_post.*, anax_user.username, anax_user.email, anax_user.id as user_id", "post")
			   		->where('anax_post.parent_post = '.$id)
			   		->andWhere('anax_post.is_answer IS NULL')
				    ->join('user', 'anax_post.created_by_user = anax_user.id')
				    ->execute();

		
	   	$this->theme->setTitle("View question with id");
	    $this->views->add(
	    	'posts/view', 
	    	[
	        	'post' => $post,
	        	'answers' => $answers,
	        	'comments' => $comments
	    	],
	    	'default_page'
	    );
	    if($this->session->get('current_user') != null){
		    $this->views->add(
		        'posts/form-answer',
		        [
		        	'id'	=>	$id,
		        	'isAnswer' => true
		        ],
		        'default_page'
		    ); 	
	    }
	    
	}
 

	/**
	 * Add new question.
	 *
	 * @param string $acronym of user to add.
	 *
	 * @return void
	 */
	public function addAction()
	{
	    if( $this->session->get('current_user') == null ){
	    	die("Missing arguments");
	    }
	    $parent_post_id = null;
	    $post_title = null;
	    $post_is_answer = null;
	    $head_comment_id = null;
	    if( isset($_POST['postTitle']) ){
	    	$post_title = $_POST['postTitle'];
	    }
	    if( isset($_POST['postParent']) ){
	    	$parent_post_id = $_POST['postParent'];
	    }
	    if( isset($_POST['postIsAnswer']) ){
			$post_is_answer = true;
	    }
	    if( isset($_POST['head_comment']) ){
	    	$head_comment_id = $_POST['head_comment'];
	    }

		//echo 'Msg: ' .$this->session->get('current_user')->id;	

	 	date_default_timezone_set('Europe/Stockholm');
	 	$now = date('y-m-d H:i:s');
	 	
	    $this->posts->create([
	        'title' => $post_title,
	        'content' => $_POST['postContent'],
	        'created_by_user' => $this->session->get('current_user')->id,
	        'parent_post' => $parent_post_id,
	        'is_answer' => $post_is_answer,
	        'created' => $now
	    ]);

	    $post_id = $this->posts->id;
	    
	    //Handle tags
	    //
	    // Create tags
	    
	    if( isset($_POST['postTags']) && $_POST['postTags'] != null){
	    	$tags = $_POST['postTags'];
			$tags = explode(",", $tags);
			$tag_ids = array();
			//print_r($tags);
			foreach ($tags as $tag) {
				$result = $this->posts->query('*','tags')
					->where('anax_tags.name = "'.$tag.'"')
					->execute();
				if(empty($result)){
					$this->posts->create([
			        'name' => $tag,
			        'created' => $now,
				    ], 'tags');
					array_push($tag_ids, $this->posts->id);
				}else{
					array_push($tag_ids, $result[0]->id);
				}
			}
			
			foreach ($tag_ids as $tag_id) {
				$this->posts->create([
			        'post_id' => $post_id,
			        'tag_id' => $tag_id,
			    ], 'postDetails');
			}
		    
	    }
    	
    	$this->flash->setSuccessMessage('Post created!');
	    
	    if($head_comment_id != null)
	    	$this->response->redirect( $this->url->create('posts/id/'.$head_comment_id) );
	    if($parent_post_id != null)
			$this->response->redirect( $this->url->create('posts/id/'.$parent_post_id) );
		else
			$this->response->redirect( $this->url->create('posts/id/'.$post_id) );
	}


	public function incrementAction($id, $parent_post = null){
		if( $this->session->get('user_has_voted') != null){
			$voted_ids = $this->session->get('user_has_voted');

			foreach ( $voted_ids as $voted_id ) {
				if( $id == $voted_id ){
					$this->flash->setErrorMessage('You have already voted');
					if($parent_post != null)
						$this->response->redirect( $this->url->create('posts/id/'.$parent_post) );
					else
						$this->response->redirect( $this->url->create('posts/id/'.$id) );
				}
			}			
		}else{
			$voted_ids = array();
		}


		$post = $this->posts->find($id)->getProperties();
		$this->posts->db->update('post',['points' => $post['points'] + 1],'id = '.$id);
		$this->posts->db->execute();

		array_push($voted_ids, $id);
		$this->session->set('user_has_voted', $voted_ids);
		
		if($parent_post != null)
			$this->response->redirect( $this->url->create('posts/id/'.$parent_post) );
		else
			$this->response->redirect( $this->url->create('posts/id/'.$id) );
	}

	public function decrementAction($id, $parent_post = null){
		if( $this->session->get('user_has_voted') != null){
			$voted_ids = $this->session->get('user_has_voted');

			foreach ( $voted_ids as $voted_id ) {
				if( $id == $voted_id ){
					$this->flash->setErrorMessage('You have already voted');
					if($parent_post != null)
						$this->response->redirect( $this->url->create('posts/id/'.$parent_post) );
					else
						$this->response->redirect( $this->url->create('posts/id/'.$id) );
				}
			}			
		}else{
			$voted_ids = array();
		}

		$post = $this->posts->find($id)->getProperties();
		$this->posts->db->update('post',['points' => $post['points'] - 1],'id = '.$id);
		$this->posts->db->execute();

		array_push($voted_ids, $id);
		$this->session->set('user_has_voted', $voted_ids);

		if($parent_post != null)
			$this->response->redirect( $this->url->create('posts/id/'.$parent_post) );
		else
			$this->response->redirect( $this->url->create('posts/id/'.$id) );
	    
	}
	
	public function commentAction($id, $parent_post = null){
		$this->theme->setTitle('Bajs');
		$this->views->add(
			'posts/form-comment',
			[
				'id' => $id,
				'parent_post' => $parent_post
			],
			'default_page'
		);
	}
}