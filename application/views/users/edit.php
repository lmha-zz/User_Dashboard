<?php
if(!$this->session->userdata('loggedIn')) {
	$this->session->set_flashdata('login_errors', "<p class='error'>Please log in.</p>");
	redirect('/users/signin');
}

ini_set('date.timezone', 'America/Los_Angeles');

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
				<a href="/users" class="navbar-brand">Test App</a>
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
					<li class="active"><a href="/users/edit">Profile</a></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
					<li><a href="/users/logoff">Log Off</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div id="content_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h3>Edit profile</h3>
				</div>
				<?php
					if($this->session->userdata('user_level') == "admin") {
						?>
						<div class="col-sm-6">
							<a href="/dashboards/admin" class="btn btn-primary pull-right">Return to Dashboard</a>
						</div>
						<?php
					}
				?>
			</div>
			<div class="row">
				<div class="col-sm-6 span1">
					<h5 id="edit_info_header">Edit Information</h5>
					<form class="form-horizontal" role="form" action="/users/process" method="post">
						<div class="form-group">
							<div class="col-sm-12">
								<label for="email">Email Address:
									<input class="form-control" type="email" id="email" name="email" placeholder="<?= $email ?>">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label for="first_name">First Name:
									<input class="form-control" type="text" id="first_name" name="first_name" placeholder="<?= $first_name ?>">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label for="last_name">Last Name:
									<input class="form-control" type="text" id="last_name" name="last_name" placeholder="<?= $last_name ?>">
								</label>
							</div>
						</div>
						<?php
						if($this->session->userdata('user_level') == "admin") {
							?>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="user_level">User Level:
										<select class="form-control col-sm-12" name="user_level" id="user_level">
											<option value="<?= ucwords($user_level) ?>"><?= ucwords($user_level) ?></option>
											<?php
											if($user_level == 'normal') {
												?>
												<option value="admin">Admin</option>
												<?php
											} else {
												?>
												<option value="normal">Normal</option>
												<?php
											}
											?>
										</select>
									</label>
								</div>
							</div>
						<div class="form-group">
							<div class="col-sm-4 pull-right">
								<input class="form-control btn btn-success" type="submit" name="update_user" value="Save">
							</div>
						</div>
							<?php
						}
						?>
					</form>
				</div>
				<div class="col-sm-6 span1 pull-right">
					<h5 id="change_pw_header">Change Password</h5>
					<form class="form-horizontal" role="form" action="/users/process" method="post">
						<div class="form-group">
							<div class="col-sm-12">
								<label for="password">Password:
									<input class="form-control col-sm-12" type="password" id="password" name="password" placeholder="Enter Password">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label for="password_confirmation">Confirm Password:
									<input class="form-control col-sm-12" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6 col-sm-offset-6">
								<input class="form-control btn btn-success" type="submit" name="update_password" value="Update Password">
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 span1">
					<h5 id="edit_desc_header">Edit Description</h5>
					<form class="form-horizontal" role="form" action="/users/process" method="post">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="col-sm-12">
									<textarea class="form-control" id="description" name="description"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2 pull-right">
									<input class="form-control btn btn-success" type="submit" name="update_description" value="Save">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>