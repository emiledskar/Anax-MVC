<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <!-- <h2 class="text-center">Ask your question</h2> -->
        <h2 class="text-center">Ask Question</h2>
        <hr/>
        <form method="post" action="<?=$this->url->create('posts/add')?>">
            <div class="form-group">
                <label for="postTitle">Title</label>
                <input id="postTitle" name='postTitle' class="form-control" type="text">
            </div>
            <div class="form-group">
                <label for="postContent">Content</label>
                <textarea id="postContent" name='postContent' class="form-control" rows="7"></textarea>
            </div>
            <div class="form-group">
                <label for="postTags">Tags</label>
                <p class="help-block">Separate each tag with a comma, ex: tag1, tag2, tag3</p>
                <input id="postTags" name='postTags' class="form-control" type="text"></input>
            </div>
            <button type='submit' class="btn btn-primary pull-right">Ask</button>
        </form>
    </div>
</div>