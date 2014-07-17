<?php

ini_set('date.timezone', 'America/Los_Angeles');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Page</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/index_style.css">
</head>
<body>

	<nav class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="/users" class="navbar-brand">Test App</a>
			</div>
			<div class="navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="/users">Home</a></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
					<li><a href="/users/signin">Sign In</a></li>
					<li><a href="/users/register">Register</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div id="content_wrapper">
		<div class="container">
			<div class="row">
				<div class="jumbotron col-sm-12">
					<h1>Welcome to the Test</h1>
					<p>We're going to build a cool application using a MVC framework!  This application was built with the Village88 folks!</p>
					<p>
						<a class="btn btn-primary btn-large" href="/users/signin">Start</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<h3>Manage Users</h3>
					<p>Using this application, you'll learn how to add, remove, and edit users for the application.</p>
				</div>
				<div class="col-md-4">
					<h3>Leave Messages</h3>
					<p>Users will be able to leave a message to another user using this application.</p>
				</div>
				<div class="col-md-4">
					<h3>Edit User Information</h3>
					<p>Admins will be able to edit another user's information (email addres, first name, last name, etc).</p>
				</div>
			</div>
		</div>
	</div>

</body>
</html>