<?php
session_start();
require('../connection.php');
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
?>
<html><head>
<link href="css/admin_styles.css?v=2.0" rel="stylesheet" type="text/css" />
</head><body bgcolor="tan">



<h1>ADMINISTRATION CONTROL PANEL </h1>
<nav>
<a href="admin.php">Home</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a> |<a href="new_poll.php">New Poll</a> | <a href="admin_approval.php">Approve Poll result</a> |<a href="logout.php">Logout</a>
</nav>

<p align="center">&nbsp;</p>
<div id="container">

<p>Click a link above to perform an administrative operation.</p>



</div>

</body></html>