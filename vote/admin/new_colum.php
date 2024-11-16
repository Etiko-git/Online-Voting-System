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

// Initialize variables for database name and table name
$database_name = '';
$table_name = '';

// Check if the form for adding column names is submitted
if(isset($_POST['add_columns'])) {
    $database_name = $_POST['database_name'];
    $table_name = $_POST['table_name'];
    $column_names_str = $_POST['column_names']; // Get the comma-separated column names
    
    // Convert comma-separated string to an array of column names
    $column_names = explode(',', $column_names_str);
    
    // Trim each column name and remove any empty elements
    $column_names = array_map('trim', $column_names);
    $column_names = array_filter($column_names);
    
    // Select the created database
    $conn->select_db($database_name);
    
    // Alter table to add columns
    foreach ($column_names as $column_name) {
        $sql = "ALTER TABLE $table_name ADD $column_name VARCHAR(50)";
        $conn->query($sql);
    }
    
    // Redirect to success page
    header("Location: poll_success.php");
    exit();
}

$conn->close();
?>
<html><head>
<title>Add Columns</title>
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


<h2>Add Columns</h2>
<form method="post" action="">
    Database Name: <input type="text" name="database_name" value="<?php echo isset($_GET['database_name']) ? $_GET['database_name'] : ''; ?>"><br><br>
    Table Name: <input type="text" name="table_name" value="<?php echo isset($_GET['table_name']) ? $_GET['table_name'] : ''; ?>"><br><br>
    Column Names (comma separated): <input type="text" name="column_names"><br><br>
    <input type="submit" name="add_columns" value="Add Columns">
</form>


</div>

</body></html>