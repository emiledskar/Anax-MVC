<h1 class="text-center">Question</h1>
<hr/>
<div class="row">
<div class="col-xs-8 col-xs-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<?=$post->title ?>
			</div>
			<div class="panel-body">
				<div class="col-xs-2">
					<img class="gravatar-50" src="<?= get_gravatar(50,$post->email); ?>">
					<?= $post->username ?>
				</div>
				<div class="col-xs-9">
					<?=$this->textFilter->doFilter($post->content, 'shortcode, markdown'); ?>
				</div>
				<div class="col-xs-1 text-center">
					<a href="<?=$this->url->create('posts/increment/'.$post->id); ?>">
						<i class="fa fa-plus fa-lg"></i>
					</a>
					<div class="" style="font-size: 1.4em;">
						<?php if(isset($post->points)) : ?>
							<?= $post->points ?>
						<?php else: ?>
							0
						<?php endif; ?>
					</div>

					<a href="<?=$this->url->create('posts/decrement/'.$post->id); ?>">
						<i class="fa fa-minus fa-lg"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<?php foreach($answers as $answer): ?>
	<div class="col-xs-8 col-xs-offset-2 answers">
		
				<div class="col-xs-2 text-center">
					<blockquote>
						<h6><?= $answer->username ?></h6>
						<img class="gravatar-30" src="<?= get_gravatar(30,$answer->email); ?>">
						
					</blockquote>
				</div>
				<div class="col-xs-9">
					<?=$this->textFilter->doFilter($answer->content, 'shortcode, markdown'); ?>
				</div>
				<div class="col-xs-1 text-center">
					<a href="<?=$this->url->create('posts/increment/'.$answer->id.'/'.$post->id); ?>">
						<i class="fa fa-plus fa-lg"></i>
					</a>
					<div class="" style="font-size: 1.4em;">
						<?php if(isset($answer->points)) : ?>
							<?= $answer->points ?>
						<?php else: ?>
							0
						<?php endif; ?>
					</div>

					<a href="<?=$this->url->create('posts/decrement/'.$answer->id.'/'.$post->id); ?>">
						<i class="fa fa-minus fa-lg"></i>
					</a>
				</div>
		
	</div>
	<?php endforeach; ?>
</div>
