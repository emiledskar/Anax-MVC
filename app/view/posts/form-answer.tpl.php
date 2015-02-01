<div class="row divider">
    <div class="col-xs-8 col-xs-offset-2 text-center">
        <h4><span class="label label-primary">Your Answer</span></h4>
    </div>
</div>


<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <form method="post" action="<?=$this->url->create('posts/add')?>">
        <?php if(isset($id)): ?>
            <input type=hidden name="postParent" value="<?=$id?>">
            <input type=hidden name="postIsAnswer" value="<?=$isAnswer?>">
        <?php endif; ?>
        <div class="form-group">
            <textarea id="postContent" name='postContent' class="form-control" rows="5"></textarea>
        </div>
        <button type='submit' class="btn btn-primary pull-right">Answer</button> 
        </form>
    </div>
</div>
