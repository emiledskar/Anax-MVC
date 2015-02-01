<div class="row">
	<?php foreach($posts as $post): ?>
	<?= print_r($post); ?>
	<div class="col-xs-7 col-xs-offset-3">
		<div class="panel panel-info">
			<div class="panel-body">
				<div class="col-xs-2 text-center">
					<img class="gravatar-30" src="<?= get_gravatar(30,$post->email); ?>">
					<?= $post->username ?>
				</div>
				<div class="col-xs-9">
					<?=$this->textFilter->doFilter($post->content, 'shortcode, markdown'); ?>
				</div>
				<div class="col-xs-1">
					<a href="<?=$this->url->create('posts/increment/'.$post->id); ?>">
						<i class="fa fa-plus fa-lg"></i>
					</a>
					<br/>
					<span style="font-size:1.6em; margin-left: 1px;">
						<?php if(isset($post->points)) : ?>
							<?=$post->points?>
						<?php else: ?>
							0
						<?php endif; ?>
					</span>
					<br/>
					<a href="<?=$this->url->create('posts/decrement/'.$post->id); ?>">
						<i class="fa fa-minus fa-lg"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
