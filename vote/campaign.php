<?php
require('connection.php');

session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['candidate_id'])){
 header("location:access-denied.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $degree = $_POST["degree"];
    $background = $_POST["background"];
    $pastpos = $_POST["pastpos"];
    $position = $_POST["position"];
    $info = $_POST["info"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            // Prepare and bind the SQL statement with parameterized query
            $stmt = $con->prepare("INSERT INTO campaign (first_name, last_name,degree, background, pastpos, position, info, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                echo "Error preparing statement: " . $con->error;
            } else {
                $stmt->bind_param("ssssssss", $firstName, $lastName, $degree, $background, $pastpos, $position, $info, $target_file);
                // Execute the statement
                if ($stmt->execute()) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $stmt->error;
                }
                // Close the statement
                $stmt->close();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>
<html><head>
<link href="css/user_styles.css?v=1.0" rel="stylesheet" type="text/css" />
</head><body bgcolor="tan">

<center><b><font color = "brown" size="6"></font></b></center><br><br>
<div id="page">
<div id="header">
<h1> Fill in your details....... </h1>
<nav>
<a href="candidate.php">Home</a> | <a href="campaign.php">Campaign</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="changepass.php">Change Password</a>| <a href="logout.php">Logout</a>
</nav>
<!-- <a href="candidate.php">Home</a> | <a href="campaign.php">Campaign</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="changepass.php">Change Password</a>| <a href="logout.php">Logout</a>
-->
</div>
<div id="container">

<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="red">
<form action="" method="post" enctype="multipart/form-data" >
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br><br>
        
        <label for="Educational Degree">Educational Degree:</label>
        <input type="text" id="degree" name="degree" required><br><br>

        
        <label for="Educational Background">Educational Background:</label>
        <input type="text" id="background" name="background" required><br><br>

        
        <label for="pastpos">Select Your Past Position. If not select "NILL":</label>
        <select id="pastpos" name="pastpos">
            <option value=""></option>
            <option value="Nill">Nill</option>
            <option value="Chairperson">Chairperson</option>
            <option value="Secretary">Secretary</option>
            <option value="Vice-secretary">Vice-secretary</option>
            <option value="HOD">HOD</option>
            <option value="Vice-Chairperson">Vice-Chairperson</option>
            <option value="Vice-Treasurer">Vice-Treasurer</option>
            <option value="Organizing-Secretary">Organizing-Secretary</option>
        </select><br>

        <label for="Position">Select Your Position:</label>
        <select id="position" name="position">
            <option value="Chairperson">Chairperson</option>
            <option value="Secretary">Secretary</option>
            <option value="Vice-secretary">Vice-secretary</option>
            <option value="HOD">HOD</option>
            <option value="Vice-Chairperson">Vice-Chairperson</option>
            <option value="Vice-Treasurer">Vice-Treasurer</option>
            <option value="Organizing-Secretary">Organizing-Secretary</option>
        </select><br><br>

        <label for="info">Information About Yourself:</label><br>
        <textarea id="info" name="info" rows="4" cols="50" required></textarea><br><br>

        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload"><br><br>

        <input type="submit" value="Submit" name="submit">
</form>
</body></html>
