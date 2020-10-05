<?php
/*
 * File displaying header
 * of pages
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> <?php echo APP_NAME; ?> | <?php echo APP_DESCRIPTION; ?></title>
  <link rel="icon" href="/public/img/favicon.png" sizes="24x24" type="image/png"> 
  <!-- Bootstrap -->
  <link rel="stylesheet" href="//tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//tools-static.wmflabs.org/cdnjs/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Default stylesheet -->
  <link href="/public/css/style.css" rel="stylesheet">
</head>

<body>
<!-- navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="collapse navbar-collapse container boxed" id="navbarNavAltMarkup">
		<div class="navbar-nav">
			<a class="nav-item nav-link" href="/"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
			<a class="nav-item nav-link" href="/about"><i class="fa fa-cube"></i> About</a>
			<?php if ( IS_LOGGEDIN && IS_ALLOWED ) {?>
				<a class="nav-item nav-link" href="/batch/create"><i class="fa fa-pencil-square-o"></i> Create batch</a>
				
				<!-- Summary menu
				<div class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart" aria-hidden="true"></i> Summary
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="/batch/summary/delivered">Delievered</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/batch/summary/failures">Failures</a>
					</div>
				</div>
				-->
			<?php }?>
		</div>
		<?php if ( IS_LOGGEDIN ) {?>
			<a href="/logout" class="btn btn-success btn-logout"><i class="fa fa-sign-out"></i> Logout</a>
		<?php }?>
	</div>
</nav>
<section class="container boxed">
	<section class="jumbotron">