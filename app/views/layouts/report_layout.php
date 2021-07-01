<!DOCTYPE html>
<html>

<head>
	<title><?php echo $this->report_title; ?></title>
	<style>
		@page {
			margin: 0px;
			font-family: Arial, Helvetica, sans-serif;
		}

		body,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			margin: 0px;
			padding: 0px;
			font-family: Arial, Helvetica, sans-serif;
		}

		small {
			font-size: 12px;
			color: #888;
		}

		.ajax-page-load-indicator {
			display: none;
			visibility: hidden;
		}

		#report-header {
			position: relative;
			border-top: 2px solid #0066cc;
			border-bottom: 5px solid #0066cc;
			background: #fafafa;
			padding: 10px;
		}
		
		#report-header table{
			margin:0;
		}
		
		#report-header .sub-title {
			font-size: small;
			color: #888;
		}

		#report-header img {
			height: 50px;
			width: 50px;
		}

		#report-title {
			background: #fafafa;
			margin-top: 20px;
			margin-bottom: 20px;
			padding: 10px 20px;
			font-size: 24px;
		}
		#report-body{
			padding: 20px;
		}

		#report-footer {
			padding: 10px;
			background: #fafafa;
			border-top: 2px solid #0066cc;
			position: absolute;
			bottom: 0;
			left:0;
			width: 98%;
			overflow: hidden;
			margin: 0 auto;
		}
		
		#report-footer table{
			margin: 0;
			overflow: hidden;
		}

		table,
		.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 1rem;
			border-collapse: collapse;
		}

		.table th,
		.table td {
			padding: 0.75rem;
			vertical-align: top;
			border-top: 1px solid #eceeef;
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #eceeef;
		}

		.table tbody+tbody {
			border-top: 2px solid #eceeef;
		}

		.table .table {
			background-color: #fff;
		}

		.table-sm th,
		.table-sm td {
			padding: 0.3rem;
		}

		.table-bordered {
			border: 1px solid #eceeef;
		}

		.table-bordered th,
		.table-bordered td {
			border: 1px solid #eceeef;
		}

		.table-bordered thead th,
		.table-bordered thead td {
			border-bottom-width: 2px;
		}

		.table-striped tbody tr:nth-of-type(odd) {
			background-color: rgba(0, 0, 0, 0.05);
		}

		.table-hover tbody tr:hover {
			background-color: rgba(0, 0, 0, 0.075);
		}

		.table-active,
		.table-active>th,
		.table-active>td {
			background-color: rgba(0, 0, 0, 0.075);
		}

		.table-hover .table-active:hover {
			background-color: rgba(0, 0, 0, 0.075);
		}

		.table-hover .table-active:hover>td,
		.table-hover .table-active:hover>th {
			background-color: rgba(0, 0, 0, 0.075);
		}

		.table-success,
		.table-success>th,
		.table-success>td {
			background-color: #dff0d8;
		}

		.table-hover .table-success:hover {
			background-color: #d0e9c6;
		}

		.table-hover .table-success:hover>td,
		.table-hover .table-success:hover>th {
			background-color: #d0e9c6;
		}

		.table-info,
		.table-info>th,
		.table-info>td {
			background-color: #d9edf7;
		}

		.table-hover .table-info:hover {
			background-color: #c4e3f3;
		}

		.table-hover .table-info:hover>td,
		.table-hover .table-info:hover>th {
			background-color: #c4e3f3;
		}

		.table-warning,
		.table-warning>th,
		.table-warning>td {
			background-color: #fcf8e3;
		}

		.table-hover .table-warning:hover {
			background-color: #faf2cc;
		}

		.table-hover .table-warning:hover>td,
		.table-hover .table-warning:hover>th {
			background-color: #faf2cc;
		}

		.table-danger,
		.table-danger>th,
		.table-danger>td {
			background-color: #f2dede;
		}

		.table-hover .table-danger:hover {
			background-color: #ebcccc;
		}

		.table-hover .table-danger:hover>td,
		.table-hover .table-danger:hover>th {
			background-color: #ebcccc;
		}

		.thead-inverse th {
			color: #fff;
			background-color: #292b2c;
		}

		.thead-default th {
			color: #464a4c;
			background-color: #eceeef;
		}

		.table-inverse {
			color: #fff;
			background-color: #292b2c;
		}

		.table-inverse th,
		.table-inverse td,
		.table-inverse thead th {
			border-color: #fff;
		}

		.table-inverse.table-bordered {
			border: 0;
		}

		.table-responsive {
			display: block;
			width: 100%;
			overflow-x: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}

		.table-responsive.table-bordered {
			border: 0;
		}
	</style>
</head>

<body>
	<div id="report-header">
		<table class="table table-sm">
			<tr>
				<th align="left" valign="middle" width="60">
					<img width="50" height="50" src="<?php print_link("assets/images/logo.png") ?>" />
				</th>
				<th align="left" valign="middle">
					<h3 class="company-name"><?php echo SITE_NAME; ?></h3>
					<small class="sub-title">The Amazing and Awesome</small>
				</th>
				<th align="right" valign="middle">
					<div class="company-info">
						<div>Phone: <span class="sub-title">+2335400000000</span></div>
						<div>Email: <span class="sub-title">info@<?php echo SITE_NAME ?></span></div>
						<div>Web: <span class="sub-title"><?php echo SITE_ADDR ?></span></div>
					</div>
					
				</th>
			</tr>
		</table>
	</div>

	<div id="report-title"><?php echo $this->report_title; ?></div>
	<div id="report-body">
		<?php
		$this->render_body();
		?>
	</div>
	<div id="report-footer">
		<table class="table table-sm">
			<tr>
				<td align="left" valign="middle" width="30">
					<img width="30" height="30" src="<?php print_link("assets/images/logo.png") ?>" />
				</td>
				<td align="left" valign="middle">
					Footer content goes here.
				</td>
				<td align="right" valign="middle">
					<?php echo  human_datetime(time()); ?>
				</td>
			</tr>
		</table>
	</div>


	<?php 
		if($this->force_print){
			?>
			<script>
				window.print();
			</script>
			<?php
		}
	?>
</body>

</html>