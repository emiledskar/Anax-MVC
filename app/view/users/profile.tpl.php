<h2 class="text-primary text-center"> 
	<?=$user->username?>
	<p><small>Profile</small></p>
</h2>
<hr/>
<div class="row">
	<div class="col-xs-4 profile-questions">
		<h4 class="text-center">Questions</h4>
		<?php if($questions != null): ?>	
			<ul class="profile-answers">
			<?php foreach ($questions as $question) : ?>
				<li>
				<div class="row">
						<div class="col-xs-10">
							<a href="<?= $this->url->create('posts/id/'.$question->id) ?>">
								<?= strip_tags ( $this->textFilter->doFilter( $question->title, 'shortcode, markdown') ) ?>
							</a>
						</div>
						<div class="col-xs-2">
							<?php if( isset($question->points) ): ?>
								<?= $question->points?>
							<?php else: ?>
								0
							<?php endif; ?>
							<i class="fa fa-thumbs-o-up"></i>
						</div>
				</div>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p class="text-center text-muted">This user hasn't asked any questions</p>
		<?php endif; ?>
	</div>
	<div class="col-xs-4">
		<h4 class="text-center">Answers</h4>

		<?php if($answers != null): ?>
			<ul class="profile-answers">
				<?php foreach ($answers as $answer) : ?>
					<li>
						<div class="row">
							<div class="col-xs-10">
								<a href="<?= $this->url->create('posts/id/'.$answer->parent_post) ?>">
									<?= strip_tags ( $this->textFilter->doFilter($answer->content, 'shortcode, markdown') )?>
								</a>
							</div>
							<div class="col-xs-2">
								<?php if( isset($question->points) ): ?>
									<?=$question->points?>
								<?php else: ?>
									0
								<?php endif; ?>
								<i class="fa fa-thumbs-o-up"></i>
							</div>
						</div>
						
						
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p class="text-center text-muted">This user hasn't answered any questions</p>
		<?php endif; ?>
	</div>
	<div class="col-xs-4">
		<h4 class="text-center">Comments</h4>
		<?php if($comments != null): ?>
			<ul class="profile-comments">
			<?php foreach ($comments as $comment) : ?>
				<li>
					<div class="row">
						<div class="col-xs-12">
							<a href="<?= $this->url->create('posts/id/'.$comment->parent_post) ?>">
								<?= strip_tags ( $this->textFilter->doFilter($comment->content, 'shortcode, markdown') )?>
							</a>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p class="text-center text-muted">This user hasn't answered any questions</p>
		<?php endif; ?>

	</div>	
</div>