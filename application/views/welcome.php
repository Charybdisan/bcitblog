				<div id="featured">
					<h3>Welcome to League Blog!</h3>
					<p>
                                        League of Legends Blog is designed to give you the most updated and best content
                                        for all of your League of Legends news galore!
                                        </p>
					<input type="button" value="Read more" onClick="parent.location='/blog/view'"/>
				</div>
				<ul class="blog">
                                        {posts}
                                        <li>
                                            <div>
                                                <h3>{ptitle}</h3>
                                                <p>
                                                    <center>{slug}</center>
                                                </p>
                                                <span>
                                                <a href="/blog/view/post/{uid}"><img class="welcome_img" src="/blog/data/images/{thumb}"/></a>
                                                </span>
                                                <a href="/blog/view/post/{uid}"></a>
                                            </div>
                                        </li>
                                        {/posts}
				</ul>