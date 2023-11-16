<?php
require_once 'db_connect.php';
require_once 'email_logic.php';
require_once 'functions.php';

// Checks if user has already logged in. Will redirect to index-student.html if so
tokenRedirect('Location: index-student-guest.html', '');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp_button"])){
    $email = $_POST["email"];

    $show_error = true; // Always true until login is successful

    // "Empty Email" Error
    if(empty($email)){
        $loginResult = '3'; $error_display = 'ERROR: Empty Email Parameter';
    }
    // "Invalid Email" Error
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false && filterEmail($email) == false){
        $loginResult = '3'; $error_display = 'ERROR: Invalid Email';
    }
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == true && filterEmail($email) == true){
        $sql = "SELECT insertGuest() AS STATUS";
        $queryResult = $conn->query($sql); $row = $queryResult->fetch_assoc();
        $otpResult = $row['STATUS'];

        $message = "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>OTP Code Email</title>
            
            <!-- Include Bootstrap CSS -->
            <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css\">
        </head>
        <body class=\"bg-light\">

            <div class=\"container mt-5\">

                <div class=\"card mx-auto\" style=\"max-width: 600px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);\">
                    <div class=\"card-body text-center\">

                        <h2 class=\"text-primary\">Your OTP Code</h2>
                        <p class=\"lead\">Please use the following one-time password (OTP) code to login using a guest account:</p>

                        <div class=\"alert alert-primary\" role=\"alert\">
                            <strong>$otpResult</strong>
                        </div>

                        <p class=\"lead\">Do not share this OTP code with anyone for security reasons.</p>

                        <p>If you did not request this OTP code, please ignore this email.</p>

                    </div>
                </div>

            </div>

            <script src=\"https://code.jquery.com/jquery-3.5.1.slim.min.js\"></script>
            <script src=\"https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js\"></script>
            <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js\"></script>

        </body>
        </html>
        ";

        sendMail($email, 'KLD OAS - OTP Code', $message);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])){
    try{

    }
    catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
}
?>