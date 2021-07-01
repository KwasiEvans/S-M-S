<div class="container">
	<h4>Select your language</h4>
	<hr />
	<div class="row">
		<?php
		//Get available language files
		$files = glob(LANGS_DIR . "*.ini");
		foreach ($files as $file) {
			$langname = pathinfo($file, PATHINFO_FILENAME);;
		?>
			<a class="btn btn-secondary btn-lg" href="<?php print_link("info/change_language/$langname") ?>">

				<?php echo ucfirst($langname); ?>

			</a>
		<?php
		}
		?>
	</div>
</div>