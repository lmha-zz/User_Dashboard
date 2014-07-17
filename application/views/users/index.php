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
				<a href="/users" class="navbar-brand">CodingDojoBook App</a>
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
					<h1>Welcome to CodingDojoBook!</h1>
					<p>This project was built with CodeIgniter, an MVC framework, and a MySQL database.  All grunt-work and stress credited to me, Lisa M. Ha.</p>
					<p>
						<a class="btn btn-primary btn-large" href="/users/register">Start by Registering!</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<h3>Manage Users</h3>
					<p>Admin functionality included in this project.  Admins have the power to add, remove, or edit users!</p>
				</div>
				<div class="col-md-4">
					<h3>Leave Messages</h3>
					<p>Users have the ability to view other users' profiles and leave messages/comments on their walls.</p>
				</div>
				<div class="col-md-4">
					<h3>Edit User Information</h3>
					<p>Admins have the power to edit any users' information (email address, first name, last name, etc). Normal users have the power to edit their own information.</p>
				</div>
			</div>
		</div>
	</div>

</body>
</html>