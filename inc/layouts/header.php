<?php if(!isset($is_public)) { $is_public = true;} ?>
<!DOCTYPE html>
<html lang=en>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Widget Corp
		<?php if (isset($page_title)) {
				echo "| {$page_title}";
			}
		?>
	</title>
	<link rel="stylesheet" src="css/normalize.css" />
	<!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/public.css" type="text/css" media="all">
	<link rel="icon" type="image/x-icon" href="../power-button-2.ico">
</head>
<body>
	<div id="header" class="navbar navbar-inverse" role="header">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="index" class="navbar-brand">Widget Corp <?php if (($is_public == false && logged_in())) { echo "Admin"; } ?></a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href='admin'>Admin</a></li>
			</ul>
		</div>
	</div>