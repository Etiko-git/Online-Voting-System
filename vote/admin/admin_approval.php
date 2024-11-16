<?php
session_start();

// If your session isn't valid, it returns you to the login screen for protection
if (empty($_SESSION['admin_id'])) {
    header("location:access-denied.php");
    exit();
}

// Include the database connection file
require('../connection.php');

// Handle form submission
if (isset($_POST['approve'])) {
    $sql = "UPDATE admin_approval SET is_approved = 1 WHERE id = 1";
    if ($con->query($sql) === TRUE) {
        $message = "Results approved successfully.";
    } else {
        $message = "Error approving results: " . $con->error;
    }
} elseif (isset($_POST['disapprove'])) {
    $sql = "UPDATE admin_approval SET is_approved = 0 WHERE id = 1";
    if ($con->query($sql) === TRUE) {
        $message = "Results disapproved successfully.";
    } else {
        $message = "Error disapproving results: " . $con->error;
    }
}

// Fetch current approval status
$approval_sql = "SELECT is_approved FROM admin_approval WHERE id = 1";
$approval_result = $con->query($approval_sql);
$approval_row = $approval_result->fetch_assoc();
$is_approved = $approval_row['is_approved'];
?>

<html>
<head>
    <link href="css/admin_styles.css?v=2.0" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="tan">
    <center><b><font color="brown" size="6">Admin Approval</font></b></center><br><br>
    <nav>
<a href="admin.php">Home</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a> |<a href="new_poll.php">New Poll</a> | <a href="admin_approval.php">Approve Poll result</a> |<a href="logout.php">Logout</a>
</nav>
        <div id="container">
            <h2>Approve or Disapprove Election Results</h2>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <form method="post" action="">
                <p>Current Status: <?php echo $is_approved ? "Approved" : "Disapproved"; ?></p>
                <button type="submit" name="approve">Approve</button>
                <button type="submit" name="disapprove">Disapprove</button>
            </form>
        </div>
    </div>
</body>
</html>
