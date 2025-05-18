<?php
/**
 * Title: Form – basic contact
 * Slug:  understrap-child/form-contact-basic
 * Categories: forms
 * Keywords: contact, form
 */
?>
<!-- wp:group {"layout":{"type":"constrained","contentSize":"600px"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<form class="wp-block-contact-form" action="#" method="post">
		<p><label>Full name<br><input type="text" name="name" required></label></p>
		<p><label>Email<br><input type="email" name="email" required></label></p>
		<p><label>Phone (optional)<br><input type="text" name="phone"></label></p>
		<p><label>Message<br><textarea name="message" rows="4" required></textarea></label></p>
		<p><button type="submit" class="wp-element-button">Send Message</button></p>
	</form>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
