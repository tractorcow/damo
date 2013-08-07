<% require themedCSS('twitter', 'twitter') %>

<li class="sticker sticker-color-blue" data-role="dropdown">
	<a><i class="icon-twitter"></i>$Title</a>
	<% if LatestTweets %>
		<ul class="Tweets TweetsSidebar sub-menu light sidebar-dropdown-menu keep-opened open">
			<% loop LatestTweets %>
				<li class="Tweet">
					<label>
						<a href="http://www.twitter.com/{$User}" target="_blank" class="User">@$User</a>
						$DateObject.format('d F Y')
					</label>
					<p>$Content</p>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
</li>
