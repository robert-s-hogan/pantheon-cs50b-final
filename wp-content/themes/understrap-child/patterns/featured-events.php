/**
 * Title: Featured Events (Cards)
 * Slug: understrap/featured-events
 * Categories: featured, query
 */
?>
<!-- wp:group {"align":"full","className":"events-section py-5"} -->
<div class="wp-block-group alignfull events-section py-5">
	<!-- wp:heading {"level":3,"className":"text-center mb-4"} -->
	<h3 class="text-center mb-4">Featured Events</h3><!-- /wp:heading -->

	<!-- wp:query {"queryId":0,"query":{"perPage":2,"postType":"event"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"layout":{"type":"default","columnCount":2}} -->
			<!-- wp:group {"className":"event-card p-3 border rounded mb-3"} -->
			<div class="wp-block-group event-card p-3 border rounded mb-3">
				<!-- wp:post-title {"level":4,"isLink":true} /-->
				<!-- wp:post-date {"format":"F j, g A"} /-->
				<!-- wp:post-excerpt {"moreText":"Read More →"} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
