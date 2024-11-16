<?php
session_start();
// If your session isn't valid, it returns you to the login screen for protection
if (empty($_SESSION['member_id'])) {
    header("location:access-denied.php");
    exit();
}

// Include the database connection file
require('connection.php');

// Check admin approval
$approval_sql = "SELECT is_approved FROM admin_approval WHERE id = 1";
$approval_result = $con->query($approval_sql);

if ($approval_result->num_rows > 0) {
    $approval_row = $approval_result->fetch_assoc();
    $is_approved = $approval_row['is_approved'];

    if (!$is_approved) {
        echo "<html> 
        <body bgcolor=#2c3e50> <p> Results are not approved for display yet.</p> </body></html>";
        exit();
    }
} else {
    echo "Approval status not found.";
    exit();
}
?>

<html>
<head>
    <link href="css/user_styles.css?v=1.0" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="js/admin.js"></script>
    <style>
        .results-text {
            margin-bottom: 20px;
        }
        .bar-chart {
            margin-top: 20px;
        }
        .bar {
            background-color: #4CAF50;
            color: white;
            padding: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body bgcolor="tan">
    <center><b><font color="brown" size="6">Election Results</font></b></center><br><br>
    <nav>
            <a href="student.php">Home</a>  <a href="vote.php">Current Polls</a>  <a href="manage-profile.php">Manage My Profile</a>  <a href="changepass.php">Change Password</a> <a href="history.php">poll History</a>  <a href="logout.php">Logout</a>
            <div class="animation start-home"></div>
        </nav>
        <div id="container">
            <form action="" method="post">
                Poll result on 20-12-2012: <button type="submit" name="show_result">Show Result</button>
            </form>

            <?php
            if (isset($_POST['show_result'])) {
                $positions = ['Chairperson', 'HOD', 'Secretary', 'Vice-Secretary', 'Organizing-Secretary'];

                foreach ($positions as $position) {
                    $sql = "SELECT * FROM tbcandidates WHERE candidate_position = '$position'";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        $total_votes = 0;
                        $candidate_votes = array();

                        // Calculate total votes and store candidate votes in an array
                        while ($row = $result->fetch_assoc()) {
                            $candidate_votes[$row['candidate_name']] = $row['candidate_cvotes'];
                            $total_votes += $row['candidate_cvotes'];
                        }

                        // Calculate and display the percentage of votes for each candidate
                        echo "<h2>Results for $position:</h2>";

                        // Textual representation
                        echo "<div class='results-text'>";
                        foreach ($candidate_votes as $candidate_name => $votes) {
                            $percentage = ($total_votes != 0) ? round(($votes / $total_votes) * 100, 2) : 0;
                            echo "<p>$candidate_name: $percentage% of $total_votes total votes (Votes: $votes)</p>";
                        }
                        echo "</div>";

                        // Bar chart representation
                        echo "<h2>Bar Chart Representation:</h2>";
                        echo "<div class='bar-chart'>";
                        foreach ($candidate_votes as $candidate_name => $votes) {
                            $percentage = ($total_votes != 0) ? round(($votes / $total_votes) * 100, 2) : 0;
                            echo "<div class='bar' style='width: $percentage%;'>$candidate_name ($percentage%)</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "No candidates found for the $position position.";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
