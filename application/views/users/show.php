<?php

ini_set('date.timezone', 'America/Los_Angeles');

function check_time($diff, $type) {
	if ($diff < 3600) {
		$timeStamp = floor($diff/60)." minutes ago";
	} elseif ($diff >= 3600 && $diff < 86400) {
		if($diff < 7200) {
			$timeStamp = floor($diff/60/60)." hour ago";
		} else {
			$timeStamp = floor($diff/60/60)." hours ago";
		}
	} elseif ((time()-strtotime($type['created_at'])) >= 86400) {
		if($diff < 172800) {
			$timeStamp = floor($diff/60/60/24)." day ago";
		} else {
			$timeStamp = floor($diff/60/60/24)." days ago";
		}
	}
	return $timeStamp;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>User Information</title>
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
					<li><a href="/users/logoff">Log Off</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div id="content_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h1><?= ucwords($user_info['first_name'].' '.$user_info['last_name']) ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<p>Registered at:</p>
					<p>User ID:</p>
					<p>Email address:</p>
					<p>Description:</p>
				</div>
				<div class="col-sm-4">
					<p><?= date('M\. jS Y', strtotime($user_info['created_at'])) ?></p>
					<p>#<?= $user_info['id'] ?></p>
					<p><?= $user_info['email'] ?></p>
					<p><?= $user_info['description'] ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<h3>Leave a message for <?= ucwords($user_info['first_name']) ?></h3>
					<?php
					if($this->session->flashdata('show_errors')) {
						echo $this->session->flashdata('show_errors');
					}
					?>
					<form class="form-horizontal" role="form" action="/users/process_message" method="post">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="col-sm-12">
									<input type="hidden" name="user_id" value="<?= $user_info['id'] ?>">
									<textarea class="form-control col-sm-12" id="message" name="message"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2 col-sm-offset-10">
									<input class="form-control btn btn-success" type="submit" name="post_message" value="Post Message">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php
			foreach ($user_msgs as $index => $message) {
				?>
				<div class="row">
					<div class="col-sm-6">
						<p><a href="/users/show/<?= $message['author_id'] ?>"><?= ucwords($message['first_name'].' '.$message['last_name']) ?></a> wrote</p>
					</div>
					<div class="col-sm-6">
						<?php
						$timeStamp = check_time(time()-strtotime($message['created_at']), $message);
						?>
						<p class="pull-right"><?= ($timeStamp) ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="spanBorder">
							<?= $message['message'] ?>
						</div>
					</div>
				</div>
				<?php
				if(count($user_msg_comments["{$message['msgId']}"]) > 0 && (!empty($user_msg_comments["{$message['msgId']}"][0][0]))) {
					$comments = $user_msg_comments["{$message['msgId']}"][0];
					foreach ($comments as $index => $comment) {
						?>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-1">
									<p><a href="/users/show/<?= $comment['user_id'] ?>"><?= ucwords($comment['first_name'].' '.$comment['last_name']) ?></a> wrote</p>
								</div>
								<div class="col-sm-5">
									<?php
									$timeStamp = check_time(time()-strtotime($comment['created_at']), $comment);
									?>
									<p class="pull-right"><?= ($timeStamp) ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-11 col-sm-offset-1">
									<div class="spanBorder">
										<?= $comment['comment'] ?>
									</div>
								</div>
							</div>
						<?php
					}
				}
				?>
				<div class="row">
					<div class="col-sm-11 col-sm-offset-1">
						<div class="comment_form_wrapper">
							<form class="form-horizontal" role="form" action="/users/process_comment" method="post">
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-12">
											<input type="hidden" name="user_id" value="<?= $user_info['id'] ?>">
											<input type="hidden" name="msg_id" value="<?= $message['msgId'] ?>">
											<textarea class="form-control col-sm-12 comment" name="comment"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-2 col-sm-offset-10">
											<input class="form-control btn btn-success" type="submit" name="post_comment" value="Post Comment">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>

</body>
</html>