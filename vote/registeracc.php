<html><head>
<link href="css/user_styles.css?v=1.0" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/user.js">
</script>
</head><body bgcolor="tan">
   
<div class="titles">Student Online voting system</div>
<div id="header">
<h1>Student Registration </h1>
<div class="news"><marquee behavior="alternate"> Register to vote for your favourate candidates. </marquee></div>
</div>

<div id="container">
<?php
require('connection.php');
//Process
if (isset($_POST['submit']))
{

$studentid = addslashes( $_POST['studentid'] );
$myFirstName = addslashes( $_POST['firstname'] ); //prevents types of SQL injection
$myLastName = addslashes( $_POST['lastname'] ); //prevents types of SQL injection
$myEmail = $_POST['email'];
$myPassword = $_POST['password'];

$newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash

$check_student = "SELECT student_id FROM student WHERE student_id='$studentid' LIMIT 1";
$check_student_query = mysqli_query($con, $check_student );
if(mysqli_num_rows($check_student_query ) > 0)
{

$sql = mysqli_query($con, "INSERT INTO tbMembers(student_id,first_name, last_name, email,password) 
VALUES ('$studentid','$myFirstName','$myLastName', '$myEmail', '$newpass') ");

if($sql){
echo "You have registered for an account.<br><br>Go to <a href=\"index.php\">Login</a>";
}
}
else{
    echo " Invalid Student ID";
    header("location: registeracc.php");
}

}
echo "<center><h3>Register an account by filling in the needed information below:</h3></center><br><br>";
echo '<form action="registeracc.php" method="post" onsubmit="return registerValidate(this)">';
echo '<table align="center" bgcolor="#44bad8"><tr><td>';
echo "<tr><td>student Id:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='studentid' maxlength='10' value=''></td></tr>";
echo "<tr><td>First Name:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='firstname' maxlength='15' value=''></td></tr>";
echo "<tr><td>Last Name:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='lastname' maxlength='15' value=''></td></tr>";
echo "<tr><td>Email Address:</td><td><input type='email' style='background-color:#999999; font-weight:bold;' name='email' maxlength='100' id='email'value=''></td><td><span id='result' style='color:red;'></span></td></tr>";
echo "<tr><td>Password:</td><td><input type='password' style='background-color:#999999; font-weight:bold;' name='password' maxlength='15' value=''></td></tr>";
echo "<tr><td>Confirm Password:</td><td><input type='password' style='background-color:#999999; font-weight:bold;' name='ConfirmPassword' maxlength='15' value=''></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type='submit' name='submit' value='Register Account'/></td></tr>";
echo "<tr><td colspan = '2'><p>Already have an account? <a href='index.php'><b>Login Here</b></a></td></tr>";
echo "</tr></td></table>";
echo "</form>";
?>
</div> 


</body>
<script src="js/jquery-1.2.6.min.js"></script>
    <script>
    $(document).ready(function(){
      
        $('#email').blur(function(event){
         
            event.preventDefault();
            var emailId=$('#email').val();
                                $.ajax({                     
                            url:'checkuser.php',
                            method:'post',
                            data:{email:emailId},  
                            dataType:'html',
                            success:function(message)
                            {
                            $('#result').html(message);
                            }
                      });
                    
           

        });

    });
   
    </script>
</html>