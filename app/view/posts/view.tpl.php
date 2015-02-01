<div class="row">
	<div class="col-xs-8 col-xs-offset-2" style="border-bottom: 1px solid #ddd;">
		<h4 class="text-primary"><img class="gravatar-30" src="<?= get_gravatar(30,$post->email); ?>"> <?= $post->username ?></h4>
	</div>
</div>
<div class="row">
	<div class="col-xs-7 col-xs-offset-2 post-content">
		<p><strong><?=$post->title ?></strong></p>
		<?=$this->textFilter->doFilter($post->content, 'shortcode, markdown'); ?>
	</div>
	<div class="col-xs-1 text-right post-rating">
			<a href="<?=$this->url->create('posts/increment/'.$post->id); ?>">
				<i class="fa fa-thumbs-o-up fa-lg"></i>
			</a>
			<div class="" style="font-size: 1.9em;">
				<?php if(isset($post->points)) : ?>
					<?= $post->points ?>
				<?php else: ?>
					0
				<?php endif; ?>
			</div>
			<a href="<?=$this->url->create('posts/decrement/'.$post->id); ?>">
				<i class="fa fa-thumbs-o-down fa-lg"></i>
			</a>
			<?php if($this->session->get('current_user') != null) :?>
				<p style="margin-top: 10px;">
					<a href="<?=$this->url->create('posts/comment/'.$post->id); ?>">
						<i class="fa fa-comment-o"></i>
					</a>
				</p>
			<?php endif; ?>
	</div>
</div>
<?php if($comments != null): ?>
<?php foreach($comments as $comment): ?>	
<div class="row">
	<div class="col-xs-6 col-xs-offset-4" style="border-top:1px solid #ddd">
			<h6><?=$comment->username?>
			<span class="text-muted"><?=$this->textFilter->doFilter($comment->content, 'shortcode, markdown'); ?></span><h6>
	</div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php if($answers != null) : ?>
<div class="row post-divider">
	<div class="col-xs-8 col-xs-offset-2 text-center">
		<h4><span class="label label-primary">Answers</span></h4>
	</div>
</div>

<?php foreach($answers as $answer): ?>
<div class="row">
	<div class="col-xs-8 col-xs-offset-2 answers" style="border-bottom: 1px solid #ddd;">
		<h4 class="text-primary"><img class="gravatar-30" src="<?= get_gravatar(30,$answer->email); ?>"> <?= $answer->username ?></h4>
	</div>
</div>
<div class="row">
	<div class="col-xs-7 col-xs-offset-2 post-content">
		<?=$this->textFilter->doFilter($answer->content, 'shortcode, markdown'); ?>
	</div>
	<div class="col-xs-1 text-right post-rating">
		<a href="<?=$this->url->create('posts/increment/'.$answer->id.'/'.$post->id); ?>">
			<i class="fa fa-thumbs-o-up fa-lg"></i>
		</a>
		<div class="" style="font-size: 1.9em;">
			<?php if(isset($answer->points)) : ?>
				<?= $answer->points ?>
			<?php else: ?>
				0
			<?php endif; ?>
		</div>

		<a href="<?=$this->url->create('posts/decrement/'.$answer->id.'/'.$post->id); ?>">
			<i class="fa fa-thumbs-o-down fa-lg"></i>
		</a>
		<?php if($this->session->get('current_user') != null) :?>
			<p style="margin-top: 10px;">
				<a href="<?=$this->url->create('posts/comment/'.$answer->id.'/'.$post->id); ?>">
					<i class="fa fa-comment-o"></i>
				</a>
			</p>	
		<?php endif; ?>	
	</div>	
</div>
<?php if($answer->comments != null): ?>
<?php foreach($answer->comments as $comment): ?>
<div class="row">
	<div class="col-xs-6 col-xs-offset-4" style="border-top:1px solid #ddd">
			<h6>
			<small class="text-muted pull-right"><?= $comment->created ?></small>
			<?=$comment->username?>
			<span class="text-muted"><?=$this->textFilter->doFilter($comment->content, 'shortcode, markdown'); ?></span>
			<h6>

	</div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php endforeach; ?>
<?php endif; ?>
