<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once 'Operations.php';
if (isset($_GET['action'])) {
	switch ($_GET['action']) {
	case 'connect':
		Operations::connect();
		//echo "Connect";
		break;
	case 'disconnect':
		Operations::disconnect();
		break;

	}
}

?>
<!DOCTYPE html>
<html>
	<?php require_once 'header.php';?>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a href="https://localhost/html/ad-php/PHP/index.php" class="navbar-brand">AppOnlyServiceForMicrosoftGraph-PHP</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="https://localhost/html/ad-php/PHP/index.php">Home</a></li>
						<li><a href="https://localhost/html/ad-php/PHP/Users.php">User Manager</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container body-content">
			<div>
			<?php if (!isset($_SESSION['access_token'])): ?>
<form method='post' action='index.php?action=connect'>

				<h1>Click the "connect" button to get the access token from Microsoft Graph</h1>
				<button class="btn btn-success">Connect</button>
</form>
			<?php else: ?>
<form method='post' action='index.php?action=disconnect'>
				<h1>Connect to Miscrosoft Graph successfully!</h1>
				<button class="btn btn-danger">disconnect</button>
</form>
			<?php endif;?>
			</div>
		</div>
	</body>
</html>
