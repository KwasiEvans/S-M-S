<div class="container">
	<h3>Password Reset </h3>
	<hr />
	<div class="">
		<h4 class="text-info bold">
			<i class="material-icons">email</i> A message has been sent to your email. Kindly follow the link to reset your password
		</h4>
		<?php
		if (DEVELOPMENT_MODE) {
			?>
			<div class="text-muted">
				To edit this file, browse to :- <i>app/view/partials/passwordmanager/password_reset_link_sent.php</i>
			</div>
		<?php
		}
		?>
	</div>
	<hr />
	<a href="<?php print_link(""); ?>" class="btn btn-info">Click here to login</a>
	<?php
	if (DEVELOPMENT_MODE) {
		$mailbody = $this->view_data;
		?>
		<hr />
		<div class="bg-light p-4 border">
			<div class="text-danger">
				<h3>
					<b>Disclaimer:</b> You are seeing this because you published under development mode.
					<br />We understand that sending email in localhost might be problematic.
				</h3>
				<div class="text-muted">To edit the email template, browse to :- <i>app/view/partials/passwordmanager/password_reset_email_template.html</i></div>
			</div>
			<hr />
			<?php echo $mailbody; ?>
		</div>
	<?php
	}
	?>
</div>