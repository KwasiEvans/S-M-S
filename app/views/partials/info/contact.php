<div class="container">
	<div class="jumbotron text-center">
		<h3>Get in touch! We're here for you...</h3>
	</div>
	<div style="margin:40px 0">
		<div class="row">
			<div class="col-sm-5">
				<div class="panel-body panel">
					<?php $this::display_page_errors(); ?>
					<h4>Share Info With Us Via Email</h4>
					<hr />
					<form method="post" action="<?php print_link("info/contact"); ?>">
						<div class="form-group">
							<input type="text" class="form-control" required id="name" name="name" placeholder="Enter Your name *">
						</div>

						<div class="form-group">
							<input type="email" class="form-control" required id="email" name="email" placeholder="Enter Your email *">
						</div>

						<div class="form-group">
							<textarea class="form-control" id="msg" name="msg" rows="4" required placeholder="Enter your Message *"></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>

				</div>
			</div>

			<div class="col-sm-7">
				<div class="panel panel-body">
					<h4>Other Ways To Reach Us:</h4>
					<hr />

					<p>
						<b class="chead"><span class="material-icons">location_on</span>Address | Location</b><br />
						<p class="adr clearfix">
							<span class="adr-group">
								<span class="street-address">Company Location Address</span><br>
								<span class="postal-code">P.O. Box 1111</span><br>
								<span class="country-name">City, Country</span>
							</span>
						</p>
					</p>
					<hr />
					<p>
						<b class="chead"><span class="material-icons">contact_phone</span> Phone</b><br />
						<span class="editContent"> +254737398979 / +254707333776</span>
					</p>
					<hr />

					<p>
						<b class="chead"><span class="material-icons">email</span> Email</b><br />
						<a href="#" class="editContent">support@<?php echo SITE_NAME ?>.com</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (DEVELOPMENT_MODE) {
	?>
		<small class="text-muted">To edit this file, browse to :- <i>app/view/partials/info/contact.php</i></small>
	<?php
	}
	?>

</div>