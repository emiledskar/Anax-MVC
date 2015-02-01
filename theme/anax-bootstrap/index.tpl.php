<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<title><?=$title . $title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<body>
<div class="container">
	<div class="header">
		<?php if ($this->views->hasContent('navbar')) : ?>
			<?php $this->views->render('navbar')?>
		<?php endif; ?>
		<?php if( $this->session->get('current_user') != null ): ?>
			<div class="btn-group">
			  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			    <i class="fa fa-user"></i> <?= $this->session->get('current_user')->username ?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="<?= $this->url->create('users/id/'.$this->session->get('current_user')->id); ?>"><i class="fa fa-user"></i> Profile</a></li>
			    <li><a href="<?= $this->url->create('users/settings'); ?>"><i class="fa fa-cog"></i> Settings</a></li>
			    <li class="divider"></li>
			    <li><a href="<?= $this->url->create('users/logout'); ?>"><i class="fa fa-sign-out"></i> Sign out</a></li>
			  </ul>
			</div>
		<?php else: ?>
			<a href="<?= $this->url->create('users/login'); ?>">
				<button type="button" class="btn btn-primary">
					Sign in
				</button>
			</a>
		<?php endif; ?>
	</div>
	<?php if ( $this->flash->getMessage() != null )  : ?>
		<?= $this->flash->getMessage() ?>
		<?php $this->flash->setMessage(null); ?>
	<?php endif; ?>

	<div class="row">
		<div class="col-md-12">
		<!-- jumbotron -->
		<?php if ($this->views->hasContent('jumbo_content')) : ?>
			<div class="jumbotron text-center">
				<?php $this->views->render('jumbo_content')?>
			</div>
		<?php endif; ?>

		<!-- default page -->
		<?php if ($this->views->hasContent('default_page')) : ?>
			<?php $this->views->render('default_page')?>
		<?php endif; ?>
		</div>
	</div>
	<?php if ($this->views->hasContent('toplists')) : ?>
		<div class="row toplists">
			<?php $this->views->render('toplists')?>
		</div>
	<?php endif; ?>
	
</div>
	
<footer>
<p>© Emil Edskär 2015</p>
</footer>
<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
