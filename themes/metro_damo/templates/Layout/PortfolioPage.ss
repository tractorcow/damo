<article class="page secondary with-sidebar" id="page-index">
	<% include PageHeader %>
	
	<div class="page-sidebar">
		<% if Tags %>
			<ul id="Sidebar">
				<% loop Tags %>
					<li><a href="$Link">$Title.XML</a></li>
				<% end_loop %>
			</ul>
		<% end_if %>
	</div>

	
	<div class="page-region">
		<div class="page-region-content">
			<% loop Items %>
				<div class="tile double portfolio-item image bg-color-red">
					<div class="tile-content">
						<div class="image start">
							$Image.CroppedImage(310, 150)
						</div>
						<div class="details start">
							<% if Client %>
								<p><label><i class="icon-user-3"></i> Client</label> <a>$Client.XML</a></p>
							<% end_if %>
							<% if Link %>
								<p><label><i class="icon-link"></i> URL</label> <a target="_blank" href="$Link.ATT">$Link</a></p>
							<% end_if %>
							<% if Tags %>
								<p><label><i class="icon-tag"></i> Tags</label>
									<% loop Tags %>
										<a href="$Link">$Title</a>
									<% end_loop %>
								</p>
							<% end_if %>
						</div>
						<div class="description">
							<% if Title %><h2>$Title.XML</h2><% end_if %>
							<% if Description %><p>$Description</p><% end_if %>
						</div>
					</div>
					<div class="brand bg-color-red">
						<span class="name">$Title.XML</span>
					</div>
				</div>
			<% end_loop %>
		</div>
	</div>
</article>
