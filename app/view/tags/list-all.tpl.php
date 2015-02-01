<h1 class="text-center">Tags</h1>
<hr/>
<div class="row">
	<div class="col-xs-8 col-xs-offset-2 text-center">
		<ul class="list-inline">
		<?php foreach ($tags as $tag) : ?>
			
			<li style="font-size:1.5em; padding: 0 10px;">
				<a class="btn btn-new" href="<?= $this->url->create('tags/id/'.$tag->id) ?>">
					<i class="fa fa-tag"></i>
					<?= $tag->name ?>
				</a>
			</li>
			
		<?php endforeach; ?>
		</ul>
	</div>
</div>