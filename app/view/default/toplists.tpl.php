
<?php if (isset($toplist_users)) : ?>
<div class="col-xs-4">
	<h4>Most active users</h4>
	<!-- TODO: list most active users -->
	<ul class="toplist-users">
		<?php foreach ($toplist_users as $user) : ?>
			<?php if($user->total_points > 0) : ?>
			<li>
				<div class="row">
					<div class="col-xs-10">			
						<a href="<?= $this->url->create('users/id/'.$user->id); ?>">
						<img class="gravatar-20" src="<?= get_gravatar( 20, $user->email); ?>">
						<span><?=$user->username?></span></a>
					</div>
					<div class="col-xs-2">
						<span class="pull-right"><?=$user->total_points?> <i class="fa fa-star-o"></i></span>
					</div>
				</div>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>	
</div>
<?php endif; ?>


<?php if (isset($toplist_questions)) : ?>
<div class="col-xs-4">
	<h4>Latest questions</h4>
	<!-- TODO: list questions -->
	<ul class="toplist-questions">
		<?php foreach ($toplist_questions as $question) : ?>
			<li>
				<div class="row">
					<div class="col-xs-10">				
						<a href="<?= $this->url->create('posts/id/'.$question->id) ?>"><?=$question->title?></a>
					</div>
					<div class="col-xs-2">
						<?php if( isset($question->answers) ): ?>
							<?=$question->answers?>
						<?php else: ?>
							0
						<?php endif; ?>
						<i class="fa fa-comments-o"></i>						
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>


<?php if (isset($toplist_tags)) : ?>
<div class="col-xs-4">
	<h4>Popular tags</h4>
	<!-- TODO: list popular tags -->
	<ul class="list-inline text-center toplist-tags">
		<?php foreach ($toplist_tags as $tag) : ?>
			<li>
				<a href="<?= $this->url->create('tags/id/'.$tag->tag_id)?>"><i class="fa fa-tag"></i> <?=$tag->name?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>