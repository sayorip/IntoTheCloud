<?php
session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
if (!isset($_SESSION['access_token'])) {
	header('Location:/');
}
require_once 'Operations.php';
$user_list = Operations::getUser();
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
						<li><a href="https://localhost/html/ad-php/PHP/">Home</a></li>
						<li><a href="https://localhost/html/ad-php/PHP/Users.php">User Manager</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container body-content">
			<button class="btn btn-default" onclick="window.location.href = 'https://localhost/html/ad-php/PHP/AddUser.php'">create a new user</button>
			<table border="1">
				<thead>
					<tr>
						<th>Display Name</th>
						<th>User Principal Name</th>
						<th>Object ID</th>
						<th>Account Enabled</th>
						<th>Edit Link</th>
						<th>Delete Link</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($user_list as $key => $value): ?>
					<tr>
						<td><?=$value->{'displayName'}?></td>
						<td><?=$value->{'userPrincipalName'}?></td>
						<td><?=$value->{'id'}?></td>
						<td><?=($value->{'accountEnabled'} ? 'True' : 'False')?></td>
						<td><a href="https://localhost/html/ad-php/PHP/EditUser.php?id=<?=$value->{'id'}?>">Edit</a></td>
						<td><a href="https://localhost/html/ad-php/PHP/DelUser.php?id=<?=$value->{'id'}?>">Del</a></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</body>
</html>
