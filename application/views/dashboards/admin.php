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
	<title>Signin Page</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
						<li class="active"><a href="/dashboards/admin">Dashboard</a></li>
						<?php
					} else {
						?>
						<li class="active"><a href="/dashboards">Dashboard</a></li>
						<?php
					}
					?>
					<li><a href="/users/edit">Profile</a></li>
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
					<h1>Manage Users</h1>
				</div>
				<div class="col-sm-6">
					<a href="/users/new_user" class="btn btn-primary pull-right">Add new</a>
				</div>
			</div>
			<?php
			if($this->session->flashdata('new_user')) {
				?>
				<div class="row">
					<div class="col-sm-5">
						<?= $this->session->flashdata('new_user') ?>
					</div>
				</div>
				<?php
			}
			if($this->session->flashdata('delete_user_success')) {
				?>
				<div class="row">
					<div class="col-sm-5">
						<?= $this->session->flashdata('delete_user_success') ?>
					</div>
				</div>
				<?php
			}
			if($this->session->flashdata('delete_user_error')) {
				?>
				<div class="row">
					<div class="col-sm-5">
						<?= $this->session->flashdata('delete_user_error') ?>
					</div>
				</div>
				<?php
			}
			?>
			<div class="row">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Created At</th>
							<th>User Level</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($users as $index => $user) {
							?>
							<tr>
								<td><?= $user['id'] ?></td>
								<td><a href="/users/show/<?= $user['id'] ?>"><?= ucwords($user['first_name'].' '.$user['last_name']) ?></a></td>
								<td><?= $user['email'] ?></td>
								<td><?= date('M\. jS Y', strtotime($user['created_at'])) ?></td>
								<td><?= $user['user_level'] ?></td>
								<td>
									<a href="/users/edit/<?= $user['id'] ?>">edit</a>
									<!-- Button trigger modal -->
									<a data-toggle="modal" data-target="#myModal<?= $user['id'] ?>">remove</a>
									<!-- End Button trigger modal -->
								</td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
				foreach ($users as $index => $user) {
					?>
					<!-- Modals -->
					<div class="modal fade" id="myModal<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?= $user['id'] ?>" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel<?= $user['id'] ?>">Confirm Delete</h4>
								</div>
								<div class="modal-body">
									<p>Are you sure you want to remove the user <?= ucwords($user['first_name'].' '.$user['last_name']) ?> registered with the email: '<?= $user['email'] ?>'?</p>
								</div>
								<div class="modal-footer">
									<form action="/users/delete/<?= $user['id'] ?>" method="post">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<input type="hidden" name="name" value="<?= ucwords($user['first_name'].' '.$user['last_name']) ?>">
										<input class="btn btn-success" type="submit" name="delete_user" value="Yes, Delete">
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- End Modals -->
					<?php
				}
				?>
			</div>
		</div>
	</div>

</body>
</html>