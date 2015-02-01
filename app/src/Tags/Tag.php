<?php
namespace Anax\Tags;

/**
 * Model for Tags
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{
	public function seed(){


	}
	
	public function popularTags(){
		return $this->query("anax_postDetails.tag_id, count(*) as occurrences, anax_tags.name",'postDetails')
	   		//->where('created_by_user = '.$this->session->get('current_user')->id )
		    ->groupby('tag_id')
		    ->orderby('occurrences DESC')
		    ->limit(20)
		    ->join('tags','anax_postDetails.tag_id = anax_tags.id')
		    ->execute();
	}

}