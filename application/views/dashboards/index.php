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
					<li class="active"><a href="/dashboards">Dashboard</a></li>
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
					<h1>All Users</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Created At</th>
								<th>User Level</th>
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
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</body>
</html>