<?php
/**
 * Title: Form – volunteer signup
 * Slug:  understrap-child/form-volunteer-signup
 * Categories: forms
 * Keywords: volunteer, signup, form
 */
?>
<!-- wp:group {"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
	<form class="wp-block-volunteer-form" action="#" method="post">
		<div style="display:flex;gap:24px;flex-wrap:wrap">
			<div style="flex:1 1 260px">
				<p><label>Full name<br><input type="text" name="name" required></label></p>
				<p><label>Email<br><input type="email" name="email" required></label></p>
				<p><label>Phone<br><input type="text" name="phone"></label></p>
			</div>
			<div style="flex:1 1 260px">
				<p><label>Volunteer Preference<br>
					<select name="pref">
						<option value="">Choose…</option>
						<option>Events &amp; Festivals</option>
						<option>Classroom Support</option>
						<option>Fundraising</option>
					</select></label></p>
				<p><label>Comments<br><textarea name="comments" rows="4"></textarea></label></p>
			</div>
		</div>
		<p style="text-align:center"><button type="submit" class="wp-element-button">Sign Me Up!</button></p>
	</form>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
