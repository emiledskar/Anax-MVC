<?php
namespace Anax\Posts;

/**
 * Model for Users.
 *
 */
class Post extends \Anax\MVC\CDatabaseModel
{

	public function seed(){
		date_default_timezone_set('Europe/Stockholm');
	 	$now = date('y-m-d H:i:s');

		/* Adds default posts */
		$this->create([
	        'title' => 'Cuadrado to Chelsea',
	        'content' => "Now it is confirmed! Juan Cuadrado joins Chelsea's squad, while André Schürrle leaves for Wolfsburg. What do you guys think about this deal? [juan cuadrado confirmed](http://sillyseason.com/football/serie/fiorentina/juan-cuadrado-posts-emotional-goodbye-fiorentina)",
	        'created_by_user' => 1,
	        'points' => 2,
	        'created' => $now,
	    ]);
	    $post1 = $this->id;

			/* Adds default tags */
		    $this->create([
		        'name' => 'Premier League',
		        'created' => $now,
		    ], 'tags');
		    $tag1 = $this->id;

		    $this->create([
		        'name' => 'Chelsea',
		        'created' => $now,
		    ], 'tags');
		    $tag2 = $this->id;

		    	/* Adds relation between tags and post */		
	    		$this->create([
			        'post_id' => $post1,
			        'tag_id' => $tag1,
			    ], 'postDetails');
	    		
			    $this->create([
			        'post_id' => $post1,
			        'tag_id' => $tag2,
			    ], 'postDetails');
		
	    $this->create([
	        'title' => 'Benzema to PL?',
	        'content' => 'Do you guys think Benzema will leave Real and sign with a team in the Premier League? And which team do you think is most likely to get his signature?',
	        'created_by_user' => 2,
	        'points' =>	1,
	        'created' => $now,
	    ]);
	    $post2 = $this->id;

			$this->create([
		        'name' => 'Real Madrid',
		        'created' => $now,
		    ], 'tags');
		    $tag3 = $this->id;		

	    		$this->create([
			        'post_id' => $post2,
			        'tag_id' => $tag3,
			    ], 'postDetails');

			    $this->create([
			        'post_id' => $post2,
			        'tag_id' => $tag1,
			    ], 'postDetails');
	}

	public function getLatestQuestions(){
		$posts = $this->query()
			->where('parent_post IS NULL')
			->orderBy('created DESC')
       		->execute();

       	foreach ($posts as $post) {
	    	$post->answers = count( $this->fetchAnswers($post->id) );
	    }
       	return $posts;
	}

	public function fetchAnswers($id){
	   	return $this->query()
        	->where('parent_post = '.$id)
        	->andWhere('is_answer IS NOT NULL')
       		->execute();     	

	}

	public function populateAnswers($id){
	   	return $this->query()
        	->where('parent_post = '.$id)
        	->join('user', 'anax_post.created_by_user = anax_user.id')
       		->execute();     	

	}

	public function fetchTags($id){
	   	return $this->query('anax_tags.name, anax_tags.id','postDetails')
	   		->where('anax_postDetails.post_id = '.$id)
        	->join('tags','anax_postDetails.tag_id = anax_tags.id')
       		->execute();
	}

	/*public function populatePosts($all){
		$all_modified = array();
	    foreach ($all as $post){
	    	//$post = $post->getProperties();
	    	//echo '<br/>created by: '.$post['created_by_user']. '<br/>';
	    	$this->users = new \Anax\Users\User();
	    	$this->users->setDI($this->di);
	     	
	     	$user = $this->users->find( $post->created_by_user );
	     	
	     	$post->created_by_user = $user->username;

	     	//echo '<br/>created by: '.$post['created_by_user']. '<br/>';
	     	$answers = $this->fetchAnswers($post->id);
	     	//echo count($answers);
	     	//var_dump( $answers );
	     	$post->answers =  count($answers);

			array_push( $all_modified,$post );
	    }
	    return $all_modified;
	}*/


	
	public function populateSinglePost($id){
		$result = $this->query("anax_post.id, anax_post.title, anax_post.content, anax_post.created, anax_post.points, anax_user.username, anax_user.id as user_id", "post")
   		->where('anax_post.id = '.$id)
	    ->join('user', 'anax_post.created_by_user = anax_user.id')
	    ->execute();

	    foreach ($result as $post) {
	    	$post->answers = $this->populateAnswers($post->id);
	    }

	    return $result;
	}

	//Method to fetch posts, their creator and their tags
	public function populatePosts(){
		$result = $this->query(" anax_post.id, anax_post.title, anax_post.content, anax_post.created, anax_post.points, anax_user.username, anax_user.email, anax_user.id as user_id", "post")
   		->where('parent_post IS NULL')
   		->orderBy('created DESC')
	    ->join('user', 'anax_post.created_by_user = anax_user.id')
	    ->execute();

	    foreach ($result as $post) {
	    	$post->answers = count( $this->fetchAnswers($post->id) );
	    	$post->tags = $this->fetchTags($post->id);
	    }

	    return $result;
	}
}