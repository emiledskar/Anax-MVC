<h2><?=$title?></h2>
<p class="lead"><?=$content?></p>
<?php if( $this->session->get('current_user') == null ): ?><p><a class="btn btn-primary" href="<?= $this->url->create('users/register'); ?>" role="button">Register</a> or <a class="btn btn-primary" href="<?= $this->url->create('users/login'); ?>" role="button">Sign in</a></p> <?php endif; ?>