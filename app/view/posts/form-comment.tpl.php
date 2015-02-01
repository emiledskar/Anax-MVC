
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <h2 class="text-center">Leave a comment</h2>
        <hr/>
        <form method="post" action="<?=$this->url->create('posts/add')?>">
        <?php if(isset($id)): ?>
            <input type=hidden name="postParent" value="<?=$id?>">
            <input type=hidden name="head_comment" value="<?=$parent_post?>">
        <?php endif; ?>
        <div class="form-group">
            <textarea id="postContent" name='postContent' class="form-control" rows="5"></textarea>
        </div>
        <button type='submit' class="btn btn-primary pull-right">Comment</button> 
        </form>
    </div>
</div>