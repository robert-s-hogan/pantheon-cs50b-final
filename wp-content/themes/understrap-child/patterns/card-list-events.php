<?php
/**
 * Title: Card list – events
 * Slug:  understrap-child/card-list-events
 * Categories: cards, query
 * Keywords: event, card
 */
?>
<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","orderby":"date","order":"asc","taxQuery":[],"metaQuery":[]}} -->
<div class="wp-block-query">
	<!-- wp:post-template -->
		<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"24px"}}},"layout":{"type":"flex","orientation":"horizontal","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group" style="margin-bottom:24px">
			<!-- wp:post-featured-image {"sizeSlug":"thumbnail"} /-->

			<!-- wp:group {"style":{"spacing":{"padding":{"left":"16px"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group" style="padding-left:16px">
				<!-- wp:post-title {"isLink":true,"fontSize":"medium"} /-->
				<!-- wp:post-date {"format":"F j · g:i a"} /-->
				<!-- wp:post-excerpt {"excerptLength":15} /-->
				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"fontSize":"small"} -->
					<div class="wp-block-button has-small-font-size"><a class="wp-block-button__link wp-element-button">Sign up&nbsp;to&nbsp;help</a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
