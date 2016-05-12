<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
if (!isset($_SESSION['access_token'])) {
	header('Location:/');
}
require_once 'Operations.php';
if (isset($_GET['id'])) {
	$response = Operations::delUser($_GET['id']);
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

			<div>
				<h2><?=$response ? $response : 'Delete successfully!';?></h2>
				<br>
				<button class="btn btn-default" type="button" onclick="window.location.href = '/Users.php'">back</button>
			</div>
		</div>
	</body>
</html>