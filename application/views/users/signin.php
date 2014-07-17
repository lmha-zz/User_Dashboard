<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Signin Page</title>
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
					<li><a href="/users">Home</a></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="/users/signin">Sign In</a></li>
					<li><a href="/users/register">Register</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div id="content_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-5">
					<h1>Signin: </h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<?php
					if($this->session->flashdata('login_errors')) {
						echo $this->session->flashdata('login_errors');
					}
					?>
				</div>
			</div>
			<div class="row">
				<form class="form-horizontal" role="form" action="/users/process_login" method="post">
					<div class="form-group col-sm-12">
						<div class="col-sm-5">
							<label for="email">Email Address:
								<input class="form-control" type="text" id="email" name="email" placeholder="Enter email">
							</label>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="col-sm-5">
							<label for="password">Password:
								<input class="form-control" type="password" id="password" name="password" placeholder="Enter Password">
							</label>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="col-sm-2 col-sm-offset-3">
							<input class="form-control btn btn-success" type="submit" name="signin" value="Sign In">
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<a href="/users/register">Don't have an account? Register.</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>