<?php
session_start();

//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize database name
$database_name = "";

// Check if the form for creating a table is submitted
if(isset($_POST['create_table'])) {
    $database_name = $_POST['database_name'];
    $table_name = $_POST['table_name'];
    
    // Select the created database
    $conn->select_db($database_name);
    
    // Create table
    $sql = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        column_name VARCHAR(30) NOT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to page to add column names
        header("Location: new_colum.php");
        exit();
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

$conn->close();
?>
<html><head>
<title>Create Table</title>
<link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
</head><body bgcolor="tan">
<center><a href ="https://sourceforge.net/projects/pollingsystem/"><img src = "images/logo" alt="site logo"></a></center><br>     
<center><b><font color = "brown" size="6"></font></b></center><br><br>
<div id="page">
<div id="header">
<h1>ADMINISTRATION CONTROL PANEL </h1>
<a href="admin.php">Home</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a> |<a href="new_poll.php">New Poll</a> | <a href="logout.php">Logout</a>
</div>
<p align="center">&nbsp;</p>
<div id="container">




<h2>Create Table</h2>
<form method="post" action="">
    Database Name: <input type="" name="database_name" value="<?php echo $database_name; ?>"><br><br>
    Table Name: <input type="text" name="table_name"><br><br>
    <input type="submit" name="create_table" value="Create Table">
</form>


</div>

</body></html>
 /