<h1 class="text-center">List all users</h1>
<hr/>
<div class="row">
	<?php foreach ($users as $user) : ?>
		<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-body">
						<img class="gravatar-30" src="<?= get_gravatar(30,$user->email); ?>">
						<a class="right" href="<?=$this->url->create('users/id/'.$user->id)?>">
							<?=$user->username?>
						</a>							
						<span class=""><?=$user->email?></span>
					</div>
				</div>
		</div>
	<?php endforeach; ?>
</div>