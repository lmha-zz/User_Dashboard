<?php
if(!$this->session->userdata('loggedIn') || $this->session->userdata('user_level') != 'admin') {
	$this->session->set_flashdata('login_errors', "<p class='error'>Please log in.</p>");
	redirect('/users/signin');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>New User</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/index_style.css">
</head>
<body>

	<nav class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<?php
				if($this->session->userdata('user_level') == "admin") {
					?>
					<a href="/dashboards/admin" class="navbar-brand">Test App</a>
					<?php
				} else {
					?>
					<a href="/dashboards" class="navbar-brand">Test App</a>
					<?php
				}
				?>
			</div>
			<div class="navbar-collapse">
				<ul class="nav navbar-nav">
					<?php
					if($this->session->userdata('user_level') == "admin") {
						?>
						<li><a href="/dashboards/admin">Dashboard</a></li>
						<?php
					} else {
						?>
						<li><a href="/dashboards">Dashboard</a></li>
						<?php
					}
					?>
					<li><a href="/users/edit">Profile</a></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
					<li><a href="/dashboards/register">Log Off</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div id="content_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h1>Add a new user: </h1>
				</div>
				<div class="col-sm-6">
					<a class="btn btn-primary pull-right" href="/dashboards/admin">Return to Dashboard</a>
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
								<input class="form-control" type="email" id="email" name="email" placeholder="Enter email">
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
							<input class="form-control btn btn-success" type="submit" name="create_user" value="Create">
						</div>
					</div>
				</form>
			</div>
		</div>
		
	</div>

</body>
</html>