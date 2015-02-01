<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
        <h2 class="text-center">Register</h2>
        <hr/>
        <form method="post" action="<?=$this->url->create('users/register')?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name='username' class="form-control" type="text">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name='email' class="form-control" type="text">
            </div>            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name='password' class="form-control">
            </div>
            <button type='submit' class="btn btn-primary pull-right">Register</button>
        </form>
    </div>
</div>