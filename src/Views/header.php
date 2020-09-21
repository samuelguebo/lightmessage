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
		<a class="nav-item nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
		<a class="nav-item nav-link" href="#">Features</a>
		<a class="nav-item nav-link" href="#">Pricing</a>
		</div>
	</div>
</nav>
<section class="container boxed">
	<section class="jumbotron">