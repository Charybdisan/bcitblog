<h1>Posts, Newest First</h1>
<p>{addpost}</p>
{posts}
<div class="row-fluid">
    <div class="span12">
        <a href="/blog/view/post/{uid}"><img src="{jump}data/images/{thumb}" class="blog_thumbnail"/></a>
        #{postNum} <a href="/blog/view/post/{uid}">{ptitle}</a> {pdate} {buttons}

        <p>
        {slug}
          <div>
              <span class="tags">tags:
                  {sep_tags}
                  <a href="/blog/view/tag/{tag}">{tag}</a>
                  {/sep_tags}
              </span>
          </div>
        </p>
    </div>
</div>
{/posts}
<p>{addpost}</p>