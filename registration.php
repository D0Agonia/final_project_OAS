<?php
$show_message = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])) {
    $first_name = htmlspecialchars(trim($_POST['firstname']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $middle_name = htmlspecialchars(trim($_POST['middlename']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $kld_id = htmlspecialchars(trim($_POST['kld_id']));
    $password = bin2hex(random_bytes(8));
    /*$phone_number = htmlspecialchars(trim($_POST['student_no']));*/

    $show_message = true;

    // Check if all fields are filled out
    if (!empty($first_name) && !empty($surname) && !empty($middle_name) && !empty($email) && !empty($kld_id)) {
        try{
          // edit this line 16
          $mysqli = new mysqli("localhost", "root", "", "OnlineAppointment");

          // Check connection
          if ($mysqli->connect_error) {
              die("Connection failed: " . $mysqli->connect_error);
          }
          $sql = "SELECT insertCredentials('$kld_id', '$password') AS STATUS";
          $queryResult = $mysqli->query($sql); $row = $queryResult->fetch_assoc();
          $credentialResult = $row['STATUS'];

          $stmt = $mysqli->prepare("INSERT INTO UserDetails (firstname, surname, middlename, email, kld_id) VALUES (?, ?, ?, ?, ?)");
          $stmt->bind_param("sssss", $first_name, $surname, $middle_name, $email, $kld_id);
          $stmt->execute();
        }
        catch(Exception $e){
          echo "Error: " . $e->getMessage();
        }

        if ($stmt->affected_rows > 0 && $credentialResult == true) {
            $display_message = "Registration Successful!";
        } elseif($stmt->affected_rows == 0 && $credentialResult == true) {
            $display_message = "Error: " . $stmt->error;
        }
        elseif($credentialResult == false){
            $display_message = "Error: KLD ID Already Exists";
        }

        $stmt->close();
        $mysqli->close();
    } else {
        echo "Please fill out all fields.";
    }
}
?>


<!DOCTYPE html>
<!-- Designined by CodingLab - youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Responsive Registration Form | CodingLab </title>
    <link rel="stylesheet" href="./css/style.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
<div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Surname</span>
            <input type="text" placeholder="Enter your Surname" required name="surname">
          </div>
          <div class="input-box">
            <span class="details">Student No.</span>
            <input type="text" placeholder="Enter your Student No." required name="kld_id">
          </div>
          <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" placeholder="Enter your First Name" required name="firstname">
          </div>
          <div class="input-box">
            <span class="details">KLD Email Address</span>
            <input type="text" placeholder="Enter your Course" required name="email">
          </div>
         
          <div class="input-box">
            <span class="details">Middle Name</span>
            <input type="text" placeholder="Enter your Middle Name" required name="middlename">
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" placeholder="Enter your Phone number" name="phone_no">
          </div>
        </div>
        
        <?php if($show_message == true){
          echo '<p class="text-center fw-bold">' . $display_message . "</p>";
        }
        ?>
        <div class="button">
          <input type="submit" value="Register" name="submit_button">
        </div>
        <a href="admin.html"> <center> Back to Dashboard </a> </center>
      </form>
    </div>
  </div>

</body>
</html>
