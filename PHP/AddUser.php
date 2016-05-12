<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
if (!isset($_SESSION['access_token'])) {
	header('Location:/');
}
require_once 'Operations.php';
if (count($_POST)) {
	$response = Operations::addUser($_POST);
}
?>
<!DOCTYPE html>
<html>
	<?php require_once 'header.php';?>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a href="https://localhost/html/ad-php/PHP/" class="navbar-brand">AppOnlyServiceForMicrosoftGraph-PHP</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="https://localhost/html/ad-php/PHP/">Home</a></li>
						<li><a href="https://localhost/html/ad-php/PHP/Users.php">User Manager</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container body-content">
			<!-- form -->
			<?php if (!count($_POST)): ?>
			<form method="post" action="https://localhost/html/ad-php/PHP/AddUser.php">
				<div class="form-group">
					<label for="displayName" class="control-label">display name</label>
					<div>
						<input type="text" name="displayName">
					</div>
				</div>
				<div class="form-group">
					<label for="mailNickname" class="control-label">mail nick name</label>
					<div>
						<input type="text" name="mailNickname">
					</div>
				</div>
				<div class="form-group">
					<label for="username" class="control-label">principal name</label>
					<div>
						<input type="text" name="userPrincipalName">
					</div>
				</div>
				<div class="form-group">
					<label for="username" class="control-label">password</label>
					<div>
						<input type="password" name="password">
					</div>
				</div>
				<div class="form-group">
					<label for="accountenabled" class="control-label">Account Enabled</label>
					<div>
						<span>True:</span><input type="radio" value=1 name="accountenabled" checked="">
						<span>False:</span><input type="radio" value=0 name="accountenabled">
					</div>
				</div>
				<div class="form-group">
					<label for="forceChangePasswordNextSignIn" class="control-label">Force Password Change on Next Login:</label>
					<div>
						<span>True:</span><input type="radio" value=1 name="forceChangePasswordNextSignIn" checked="">
						<span>False:</span><input type="radio" value=0 name="forceChangePasswordNextSignIn">
					</div>
				</div>
				<button type="submit" class="btn btn-success">submit</button>
				<button type="button" class="btn btn-default" onclick="window.location.href = 'https://localhost/html/ad-php/PHP/Users.php'">cancel</button>
			</form>
			<?php else: ?>
			<!-- message div -->
			<div>
				<h2><?=$response?></h2>
				<br>
				<button class="btn btn-default" type="button" onclick="window.location.href = 'https://localhost/html/ad-php/PHP/AddUser.php'">back</button>
			</div>
			<?php endif;?>
		</div>
	</body>
</html>
