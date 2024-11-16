<?php
require('../connection.php');
// retrieving candidate(s) results based on position
if (isset($_POST['Submit'])){   
/*
$resulta = mysqli_query($con, "SELECT * FROM tbCandidates where candidate_name='Luis Nani'");

while($row1 = mysqli_fetch_array($resulta))
  {
  $candidate_1=$row1['candidate_cvotes'];
  }
  */
  $position = addslashes( $_POST['position'] );
  
    $results = mysqli_query($con, "SELECT * FROM tbCandidates where candidate_position='$position'");

    $row1 = mysqli_fetch_array($results); // for the first candidate
    $row2 = mysqli_fetch_array($results); // for the second candidate
      if ($row1){
      $candidate_name_1=$row1['candidate_name']; // first candidate name
      $candidate_1=$row1['candidate_cvotes']; // first candidate votes
      }

      if ($row2){
      $candidate_name_2=$row2['candidate_name']; // second candidate name
      $candidate_2=$row2['candidate_cvotes']; // second candidate votes
      }
}
    else
        // do nothing
?> 
<?php
// retrieving positions sql query
$positions=mysqli_query($con, "SELECT * FROM tbPositions");
?>
<?php
session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
?>

<?php if(isset($_POST['Submit'])){$totalvotes=$candidate_1+$candidate_2;} ?>

<html><head>
<link href="css/admin_styles.css?v=2.0" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/admin.js">
</script>
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
    

</head><body bgcolor="tan">
<center><b><font color = "brown" size="6"></font></b></center><br><br>

<h1>POLL RESULTS </h1><nav>
<a href="admin.php">Home</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a>  | <a href="logout.php">Logout</a>
</nav>
<div id="container">
<table width="420" align="center">
<form name="fmNames" id="fmNames" method="post" action="refresh.php" onSubmit="return positionValidate(this)">
<h2>Select Candidate Position</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="position">Select Position:</label>
    <select name="position" id="position">
    <option value="">-</option>
            <option value="Chairperson">Chairperson</option>
            <option value="Secretary">Secretary</option>
            <option value="Vice-secretary">Vice-secretary</option>
            <option value="HOD">HOD</option>
            <option value="Vice-Chairperson">Vice-Chairperson</option>
            <option value="Vice-Treasurer">Vice-Treasurer</option>
            <option value="Organizing-Secretary">Organizing-Secretary</option>
        <!-- Add more options as needed -->
    </select>
    <input type="submit" name="submit" value="Submit">
</form>

</table>
<?php
require_once('../connection.php');

// Check if form is submitted
if(isset($_POST['submit'])) {
    $position = $_POST['position'];

    // Fetch candidates for the selected position from the database
    $sql = "SELECT * FROM tbcandidates WHERE candidate_position = '$position'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $total_votes = 0;
        $candidate_votes = array();

        // Calculate total votes and store candidate votes in an array
        while($row = $result->fetch_assoc()) {
            $candidate_votes[$row['candidate_name']] = $row['candidate_cvotes'];
            $total_votes += $row['candidate_cvotes'];
        }

        // Calculate and display the percentage of votes for each candidate
        echo "<h2>Results for $position:</h2>";

        // Textual representation
        echo "<div class='results-text'>";
        foreach($candidate_votes as $candidate_name => $votes) {
            $percentage = ($total_votes != 0) ? round(($votes / $total_votes) * 100, 2) : 0;
            echo "<p>$candidate_name: $percentage% of $total_votes total votes (Votes: $votes)</p>";
        }
        echo "</div>";

        // Bar chart representation
        echo "<h2>Bar Chart Representation:</h2>";
        echo "<div class='bar-chart'>";
        foreach($candidate_votes as $candidate_name => $votes) {
            $percentage = ($total_votes != 0) ? round(($votes / $total_votes) * 100, 2) : 0;
            echo "<div class='bar' style='width: $percentage%;'>$candidate_name ($percentage%)</div>";
        }
        echo "</div>";
    } else {
        echo "No candidates found for the selected position.";
    }
}
?>

</div>

</body></html>