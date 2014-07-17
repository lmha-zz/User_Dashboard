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
					<li><a href="/users/signin">Sign In</a></li>
					<li class="active"><a href="/users/register">Register</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div id="content_wrapper">
		<div class="container">
			<?php
			if($this->session->flashdata('delete_user_success')) {
				?>
				<div class="row">
					<div class="col-sm-12">
						<?= $this->session->flashdata('delete_user_success') ?>
					</div>
				</div>
				<?php
			}
			?>
			<div class="row">
				<div class="col-sm-5">
					<h1>Register: </h1>
				</div>
			</div>
			<?php
			if($this->session->flashdata('register_errors')) {
				?>
				<div class="row">
					<div class="col-sm-5">
						<?= $this->session->flashdata('register_errors') ?>
					</div>
				</div>
				<?php
			}
			?>
			<div class="row">
				<form class="form-horizontal" role="form" action="/users/process_new_user" method="post">
					<div class="form-group col-sm-12">
						<div class="col-sm-5">
							<label for="email">Email Address:
								<input class="form-control" type="text" id="email" name="email" placeholder="Enter email">
							</label>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="col-sm-5">
							<label for="first_name">First Name:
								<input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter First Name">
							</label>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="col-sm-5">
							<label for="last_name">Last Name:
								<input class="form-control" type="text" id="last_name" name="last_name" placeholder="Enter Last Name">
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
						<div class="col-sm-5">
							<label for="password_confirmation">Confirm Password:
								<input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
							</label>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="col-sm-2 col-sm-offset-3">
							<input class="form-control btn btn-success" type="submit" name="register" value="Register">
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<a href="/users/signin">Already have an account? Login.</a>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>