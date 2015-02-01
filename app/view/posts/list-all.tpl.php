<h1 class="text-center"><?=$title?></h1>
<hr/>
<div class="row">
	<?php foreach ($posts as $post) : ?>
		<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<img class="gravatar-20" src="<?= get_gravatar(20,$post->email); ?>"> 
						<a href="<?= $this->url->create('users/id/'.$post->user_id) ?>">
							<?=$post->username?>
						</a>
						<span class="small pull-right"><?=$post->created?></span>
					</div>
		  			
		  			<div class="panel-body">
		  				<div class="col-xs-8">
		  					<a class="question-title" href="<?=$this->url->create('posts/id/'.$post->id)?>">
		  						<?= strip_tags ( $this->textFilter->doFilter($post->title, 'shortcode, markdown') ) ?>
		  					</a>
		  					<p class="question-content"><?= strip_tags ( $this->textFilter->doFilter($post->content, 'shortcode, markdown') )?></p>
		  				</div>
		  				<div class="col-xs-2 text-center">
	  						<p>
	  							<?php if(isset($post->answers)) : ?>
	  								<?= $post->answers?>
	  							<?php else: ?>
	  								0
	  							<?php endif; ?>
	  						</p>
	  						<small>Answers</small>
		  					
		  				</div>
		  				<div class="col-xs-2 text-center">
	  						<p> 
	  							<?php if(isset($post->points)) : ?>
	  								<?= $post->points ?>
	  							<?php else: ?>
	  								0
	  							<?php endif; ?>
	  						</p>
	  						<small>Points</small>
		  				</div>
						
					</div>
					<div class="panel-footer">
						<?php if(isset($post->tags) && $post->tags != null):  ?>
							<?php foreach ($post->tags as $tag): ?>
	  							<a href="<?= $this->url->create('tags/id/'.$tag->id); ?>"><button class="btn btn-link btn-xs"><i class="fa fa-tag"></i> <?=$tag->name?></button></a>
	  						<?php endforeach; ?>
						<?php else: ?>
							<button class="btn btn-link btn-xs disabled">No tags</button>
						<?php endif; ?>
					</div>
				</div>
		</div>
	<?php endforeach; ?>
</div>