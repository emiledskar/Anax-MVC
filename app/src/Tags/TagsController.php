<?php
namespace Anax\Tags;
 
/**
 * A controller for users and admin related events.
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
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
		$this->tags = new \Anax\Tags\Tag();
	    $this->tags->setDI($this->di);
	}

	/**
	 * List all posts with specified tag
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function idAction($id){
		/*$posts = $this->tags->query('*','postDetails')
					->where('anax_postDetails.tag_id = '.$id)
					->execute();*/
		$tag = $this->tags->query('anax_tags.name','tags')
					->where('anax_tags.id = '.$id)
       				->execute(true);
		
	   	$posts = $this->tags->query('*, anax_postDetails.id as detail_id, anax_user.id as user_id','postDetails')
	   				->where('anax_postDetails.tag_id = '.$id)
        			->leftJoin('post','anax_postDetails.post_id = anax_post.id')
        			->leftJoin('user','anax_post.created_by_user = anax_user.id')
       				->execute();

       	$this->theme->setTitle('View Tag');
       	$this->views->add(
       		'tags/view',
       		[
       			'title' => 'All questions for <span class="text-primary">'.$tag->name.'</span>',
       			'posts' => $posts
       		],
       		'default_page'
       	);
	}




	public function listAction(){

		$tags = $this->tags->query('*','tags')
       				->execute();

       	$this->theme->setTitle('All Tags');
		$this->views->add(
       		'tags/list-all',
       		[
       			'tags' => $tags
       		],
       		'default_page'
       	);
	}
}