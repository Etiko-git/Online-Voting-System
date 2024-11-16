<?php
require('connection.php');

session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['candidate_id'])){
 header("location:access-denied.php");
}
?>
<html><head>
<link href="css/user_styles.css?v=1.0" rel="stylesheet" type="text/css" />
</head><body bgcolor="tan">

<center><b><font color = "brown" size="6"></font></b></center><br><br>

<h1>Welcome back! </h1>
<nav>
<a href="candidate.php">Home</a> | <a href="campaign.php">Campaign</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="changepass.php">Change Password</a>| <a href="logout.php">Logout</a>
</nav>

<div id="container">
<p> Click a link above to do some stuff.</p>
</body></html>