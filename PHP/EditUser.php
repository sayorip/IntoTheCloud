<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
if (!isset($_SESSION['access_token'])) {
	header('Location:/');
}
require_once 'Operations.php';
if (count($_POST)) {
	$response = Operations::editUser($_GET['id'], $_POST);
} else {
	$user = Operations::getUser($_GET['id']);
}
?>
<!DOCTYPE html>
<html>
	<?php require_once 'header.php';?>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a href="/" class="navbar-brand">AppOnlyServiceForMicrosoftGraph-PHP</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="/">Home</a></li>
						<li><a href="/Users.php">User Manager</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container body-content">
			<!-- form -->
			<?php if (!count($_POST)): ?>
			<h2>User of ID: <?=$_GET['id']?>.</h2>
			<form method="post" action="/EditUser.php?id=<?=$_GET['id']?>">
				<div class="form-group">
					<label for="displayName" class="col-md-2 control-label">display name</label>
					<div class="col-md-10">
						<input type="text" name="displayName" value="<?=$user->{'displayName'}?>">
					</div>
				</div>
				<div class="form-group">
					<label for="username" class="col-md-2 control-label">principal name</label>
					<div class="col-md-10">
						<input type="text" name="userPrincipalName" value="<?=$user->{'userPrincipalName'}?>">
					</div>
				</div>
				<button type="submit" class="btn btn-success">submit</button>
				<button type="button" class="btn btn-default" onclick="window.location.href = '/Users.php'">cancel</button>
			</form>
			<?php else: ?>
			<!-- message div -->
			<div>
				<h2><?=$response ? $response : 'Update successfully!';?></h2>
				<br>
				<button class="btn btn-default" type="button" onclick="window.location.href = '/Users.php'">back</button>
			</div>
			<?php endif;?>
		</div>
	</body>
</html>