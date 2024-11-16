<?php
require('connection.php');

session_start();
// If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['member_id'])){
    header("location:access-denied.php");
}

// Retrieve the username from the database based on the member ID
$member_id = $_SESSION['member_id'];
$stmt = $con->prepare("SELECT email FROM tbmembers WHERE member_id = ?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
?>

<html>
<head>
    <link href="css/user_styles.css?v=1.0" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="tan">
<div class="titles">Student Online voting system</div>
    <nav>
            <a href="student.php">Home</a>  <a href="vote.php">Current Polls</a>  <a href="manage-profile.php">Manage My Profile</a>  <a href="changepass.php">Change Password</a> <a href="history.php">poll History</a>  <a href="logout.php">Logout</a>
            <div class="animation start-home"></div>
        </nav>
        <center><b><font color="brown" size="6">Welcome back, <?php echo $username; ?></font></b></center><br><br>
    
    

        <div id="container">
            <h2>Here's our Candidate Information. Check it out.</h2>
            <?php
            require_once("connection.php");
            $sql = "SELECT first_name, last_name, degree, background, pastpos, position, info, image_path FROM campaign ORDER BY id DESC";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<img src='" . $row["image_path"] . "' alt='Uploaded Image' style='width: 400px; height: 400px; border: 2px solid beige; border-radius: 10px;'><br>";
                    echo "<div class='text'><p><strong>Name:</strong> " . $row["first_name"] . " " . $row["last_name"] . "</p></div>";
                    echo "<div class='text'><p><strong>Educational Degree:</strong> " . $row["degree"] . "</p></div>";
                    echo "<div class='text'><p><strong>Educational Background:</strong> " . $row["background"] . "</p></div>";
                    echo "<div class='text'><p><strong>Past Position:</strong> " . $row["pastpos"] . "</p></div>";
                    echo "<div class='text'><p><strong>Position:</strong> " . $row["position"] . "</p></div>";
                    echo "<div class='text'><p><strong>Information:</strong> " . $row["info"] . "</p></div>";
                }
            } else {
                echo "No Candidate information found";
            }
            $con->close();
            ?>
        </div>
    
</body>
</html>
