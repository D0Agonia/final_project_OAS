<?php
require_once 'db_connect.php';
require_once 'functions.php';

function changeCredentials($input_code, $input_password){
    global $conn;
    
    if(verifyChangePasswordCode($input_code) == true){ // Verifies code if it exists
        try{
            // Grabs ID of account tied to code
            $query = "SELECT kld_id FROM ChangePasswordRequest WHERE changePassword_code = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_code);
            $stmt->execute(); $stmt->store_result(); $stmt->bind_result($user_kldID);
            $stmt->fetch();

            // Generates new salt and hashed password
            do{ $input_salt = lowercaseNumericString(32);
                $query = "SELECT salt_password FROM UserCredentials WHERE salt_password = ?";
                $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_salt);
                $stmt->execute(); $stmt->store_result(); $saltSimilar_count = $stmt->num_rows;
            } while($saltSimilar_count > 0);

            $input_hashPassword = hash('sha256', $input_password . $input_salt, true);

            // Updates password and salt of ID
            $query = "UPDATE UserCredentials SET hash_password = ?, salt_password = ? WHERE kld_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("sss", $input_hashPassword, $input_salt, $user_kldID);
            $stmt->execute();

            // Destroys code
            $query = "DELETE FROM ChangePasswordRequest WHERE changePassword_code = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_code);
            $stmt->execute();

            $stmt->close();

            return true;
        }
        catch(Exception $e){
            header("Location: ../error_message/error500");
            logError($e);
        }
    }
    else{
        return false;
    }
}

function fetchAppointmentBlacklist(){
    global $conn;

    try{
        // Array to store the blacklisted dates and times
        $blacklist = [
            'dates' => [],
            'times' => []
        ];

        $query = "SELECT DATE(appointment_datetime) AS appointment_date, COUNT(*) AS count FROM AppointmentList GROUP BY DATE(appointment_datetime)";
        $stmt = $conn->query($query);
        while ($row = $stmt->fetch_assoc()) {
            if ($row['count'] >= 300) {
                $blacklist['dates'][] = $row['appointment_date'];
            }
        }

        $query = "SELECT appointment_datetime, COUNT(*) AS count FROM AppointmentList GROUP BY appointment_datetime";
        $stmt = $conn->query($query);
        while ($row = $stmt->fetch_assoc()) {
            if ($row['count'] >= 9) {
                $blacklist['times'][] = date('H:i', strtotime($row['appointment_datetime']));
            }
        }
        
        $stmt->close();

        return $blacklist;
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function fetchDetails($input_token){
    global $conn;

    try{
        // Fetches either kld_id or guest_id from LoginTokens if it matches the session_token
        $query = "SELECT COALESCE(kld_id, guest_id) FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_token);
        $stmt->execute(); $stmt->store_result(); $stmt->bind_result($login_id);
        $stmt->fetch();

        // Fetches user details tied to the kld_id of the session_token
        if(preg_match("/^KLD/", $login_id)){
            $query = "SELECT kld_id, firstname, middlename, surname, email, phone_number FROM UserDetails WHERE kld_id = ? OR guest_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("ss", $login_id, $login_id);
            $stmt->execute(); $stmt->store_result(); $stmt->bind_result($kld_id, $firstname, $middlename, $surname, $email, $phone_number);
            $stmt->fetch();

            // Returns stored results in an array.
            $details = array(
                'loginID' => $kld_id,
                'fName' => $firstname,
                'mName' => $middlename,
                'lName' => $surname,
                'email' => $email,
                'contactNum' => $phone_number
            );
            
            return $details;
        }
        elseif(preg_match("/^GUEST/", $login_id)){
            $details = array(
                'loginID' => $login_id,
                'fName' => '',
                'mName' => '',
                'lName' => '',
                'email' => '',
                'contactNum' => ''
            );

            return $details;
        }
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function insertCredentials($input_kldID, $input_password){
    global $conn;

    if (searchKLDID($input_kldID) == false){
        try{
            // Generates salt, while ensuring no such other salt exists
            do{ $input_salt = lowercaseNumericString(32);
                $query = "SELECT salt_password FROM UserCredentials WHERE salt_password = ?";
                $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_salt);
                $stmt->execute(); $stmt->store_result(); $saltSimilar_count = $stmt->num_rows;
            } while ($saltSimilar_count > 0);

            $input_hashPassword = hash('sha256', $input_password . $input_salt, true);

            // Insertion into database
            $query = "INSERT INTO UserCredentials(kld_id, hash_password, salt_password) VALUES(?, ?, ?)";
            $stmt = $conn->prepare($query); $stmt->bind_param("sss", $input_kldID, $input_hashPassword, $input_salt);
            $stmt->execute(); $stmt->close();

            return true;
        }
        catch(Exception $e){
            header("Location: ../error_message/error500");
            logError($e);
        }
    }
    else{
        return false;
    }
}

function insertDetails($input_ID, $input_firstname, $input_middlename, $input_surname, $input_email, $input_phoneNumber, $ID_FLAG){
    global $conn;
    
    try{ switch($ID_FLAG){
        case 'INPUT_KLD_ID':
            if(searchKLDID($input_ID) == true){
                $query = "INSERT INTO UserDetails(kld_id, firstname, middlename, surname, email, phone_number) VALUES(?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query); $stmt->bind_param("ssssss", $input_ID, $input_firstname, $input_middlename, $input_surname, $input_email, $input_phoneNumber);
                $stmt->execute(); $stmt->close();

                return true;
            } break;
        case 'INPUT_GUEST_ID':
            if(searchGuestID($input_ID) == true){
                $query = "INSERT INTO UserDetails(guest_id, firstname, middlename, surname, email, phone_number) VALUES(?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query); $stmt->bind_param("ssssss", $input_ID, $input_firstname, $input_middlename, $input_surname, $input_email, $input_phoneNumber);
                $stmt->execute(); $stmt->close();

                return true;
            } break;
        default:
            return false;
            break;
    }}
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function insertGuest(){
    global $conn;
    
    try{
        // Generates otp, while ensuring no such other otp exists
        do{ $otp = lowercaseNumericString(6);
            $query = "SELECT otp_code FROM GuestCredentials WHERE otp_code = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $otp);
            $stmt->execute(); $stmt->store_result(); $otpSimilar_count = $stmt->num_rows;
        } while($otpSimilar_count > 0);

        // Generates guest_id, while ensuring no such other guest_id exists
        do{ $autogen_guestID = 'GUEST' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $query = "SELECT guest_id FROM GuestCredentials WHERE guest_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $autogen_guestID);
            $stmt->execute(); $stmt->store_result(); $guestIDSimilar_count = $stmt->num_rows;
        } while($guestIDSimilar_count > 0);

        // Insertion into database
        $query = "INSERT INTO GuestCredentials(guest_id, otp_code, otp_expiration) VALUES(?, ?, NOW() + INTERVAL 1 HOUR)";
        $stmt = $conn->prepare($query); $stmt->bind_param("ss", $autogen_guestID, $otp);
        $stmt->execute(); $stmt->close();

        return $otp;
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function requestPasswordChange($input_email){
    global $conn;
    
    try{
        // Fetches kld_id from UserDetails tied to the input email
        $query = "SELECT kld_id FROM UserDetails WHERE email = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_email);
        $stmt->execute(); $stmt->store_result(); $stmt->bind_result($user_kldID);
        $stmt->fetch();
        
        // Counts number of changePassword_code tied to the kld_id
        $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE kld_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $user_kldID);
        $stmt->execute(); $stmt->store_result(); $code_count = $stmt->num_rows;

        // Creates new change password code and returns it
        if($user_kldID != NULL && $code_count == 0){
            CreateChangePasswordCode($user_kldID);

            $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE kld_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $user_kldID);
            $stmt->execute(); $stmt->store_result();
            
            $stmt->bind_result($changePassword_code); $stmt->fetch();
            
            $stmt->close();
            return $changePassword_code;
        }
        // Fetches existing change password code and returns it
        elseif($user_kldID != NULL && $code_count > 0){
            $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE kld_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $user_kldID);
            $stmt->execute(); $stmt->store_result();
            
            $stmt->bind_result($changePassword_code); $stmt->fetch();
            
            $stmt->close();
            return $changePassword_code;
        }
        // Returns '1' if user_kldID is empty
        else{
            $stmt->close();
            return '1';
        }
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function searchKLDID($input_kldID){
    global $conn;
    
    try{ // Searches for kldID in database given input
        $query = "SELECT kld_id FROM UserCredentials WHERE kld_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_kldID);
        $stmt->execute(); $stmt->store_result();
        $kldID_count = $stmt->num_rows; $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    if($kldID_count > 0){
        return true;
    }
    else{
        return false;
    }
}

function searchGuestID($input_guestID){
    global $conn;
    
    try{ // Searches for guestID in database given input
        $query = "SELECT guest_id FROM GuestCredentials WHERE guest_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_guestID);
        $stmt->execute(); $stmt->store_result();
        $guestID_count = $stmt->num_rows; $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    if($guestID_count > 0){
        return true;
    }
    else{
        return false;
    }
}

function searchUserID($input_ID){
    global $conn;
    
    try{ // Searches for userID in database given input
        $query = "SELECT user_id FROM UserDetails WHERE user_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_ID);
        $stmt->execute(); $stmt->store_result();
        $userID_count = $stmt->num_rows; $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    if($userID_count > 0){
        return true;
    }
    else{
        return false;
    }
}

function searchToken($input_token){
    global $conn;
    
    try{ // Searches for token in database given input
        $query = "SELECT session_token FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_token);
        $stmt->execute(); $stmt->store_result(); $userToken_count = $stmt->num_rows; $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    if($userToken_count > 0){
        return true;
    }
    else{
        return false;
    }
}

function verifyChangePasswordCode($input_code){
    global $conn;
    
    try{ // Checks if changePassword_code exists in database
        $query = "SELECT kld_id FROM ChangePasswordRequest WHERE changePassword_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_code);
        $stmt->execute(); $stmt->store_result(); $kldID_count = $stmt->num_rows; $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    if($kldID_count > 0){
        return true;
    }
    else{
        return false;
    }
}

function verifyGuestLogin($input_otp){
    global $conn;
    
    try{
        // Fetches guest_id from GuestCredentials tied to the input otp
        $query = "SELECT guest_id FROM GuestCredentials WHERE otp_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_otp);
        $stmt->execute(); $stmt->store_result(); $stmt->bind_result($guest_guestID);
        $stmt->fetch();

        if($guest_guestID != NULL){
            CreateGuestSessionToken($guest_guestID);

            // Fetches session_token tied to the guest_id
            $query = "SELECT session_token FROM LoginTokens WHERE guest_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $guest_guestID);
            $stmt->execute(); $stmt->store_result(); $stmt->bind_result($session_token);
            $stmt->fetch();

            // Destroys otp
            $query = "UPDATE GuestCredentials SET otp_code = NULL, otp_expiration = NULL WHERE otp_code = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_otp);
            $stmt->execute(); $stmt->close();

            return $session_token;
        }
        // Returns '1' if guest_id not found
        else{
            $stmt->close();
            return '1';
        }
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function verifyUserLogin($input_kldID, $input_password){
    global $conn;
    
    try{
        // Grabs password and salt from UserCredentials tied to the kldID input
        $query = "SELECT hash_password, salt_password FROM UserCredentials WHERE kld_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_kldID);
        $stmt->execute(); $stmt->store_result(); $stmt->bind_result($user_password, $user_salt);
        $stmt->fetch();

        // Verifies the password
        if(hash('sha256', $input_password . $user_salt) == bin2hex($user_password)){
            CreateUserSessionToken($input_kldID);

            $query = "SELECT session_token FROM LoginTokens WHERE kld_id = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_kldID);
            $stmt->execute(); $stmt->store_result(); $stmt->bind_result($session_token);
            $stmt->fetch();

            $stmt->close();
            return $session_token;
        }
        // Returns '1' if kldID not found
        elseif(searchKLDID($input_kldID) == false){
            $stmt->close();
            return '1';
        }
        // Returns '2' if password is incorrect
        else{
            $stmt->close();
            return '2';
        }
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function verifyToken($input_token){
    global $conn;
    
    try{ // Grabs token_expiration from LoginTokens tied to the input token
        $query = "SELECT token_expiration FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_token);
        $stmt->execute(); $stmt->store_result(); 
        $stmt->bind_result($user_tokenExpiration); 
        $stmt->fetch(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    // Expired token; destroys to sync with database
    if($user_tokenExpiration <= date('Y-m-d H:i:s')){
        DestroySessionToken($input_token);

        return false;
    }
    // Token not found
    elseif(searchToken($input_token) == false){
        return false;
    }
    // Valid token
    else{
        return true;
    }
}

function CreateChangePasswordCode($input_kldID){
    global $conn;
    
    try{ do{ $code = lowercaseNumericString(64); // Generates a unique change password code. 64 characters long.
        $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE changePassword_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $code);
        $stmt->execute(); $stmt->store_result(); $codeSimilar_count = $stmt->num_rows;
    } while($codeSimilar_count > 0);

        // Insertion into database
        $query = "INSERT INTO ChangePasswordRequest(changePassword_code, changePassword_expiration, kld_id) VALUES(?, NOW() + INTERVAL 1 HOUR, ?)";
        $stmt = $conn->prepare($query); $stmt->bind_param("ss", $code, $input_kldID);
        $stmt->execute(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function CreateGuestSessionToken($input_guest){
    global $conn;
    
    try{ do{ $token = lowercaseNumericString(32); // Generates a unique guest session token. 32 characters long.
        $query = "SELECT session_token FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $token);
        $stmt->execute(); $stmt->store_result(); $tokenSimilar_count = $stmt->num_rows;
    } while($tokenSimilar_count > 0);

        $query = "INSERT INTO LoginTokens(session_token, token_expiration, guest_id) VALUES(?, NOW() + INTERVAL 1 DAY, ?)";
        $stmt = $conn->prepare($query); $stmt->bind_param("ss", $token, $input_guest);
        $stmt->execute(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function CreateUserSessionToken($input_kldID){
    global $conn;
    
    try{ do{ $token = lowercaseNumericString(32); // Generates a unique user session token. 32 characters long.
        $query = "SELECT session_token FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $token);
        $stmt->execute(); $stmt->store_result(); $tokenSimilar_count = $stmt->num_rows;
    } while($tokenSimilar_count > 0);

        $query = "INSERT INTO LoginTokens(session_token, token_expiration, kld_id) VALUES(?, NOW() + INTERVAL 1 DAY, ?)";
        $stmt = $conn->prepare($query); $stmt->bind_param("ss", $token, $input_kldID);
        $stmt->execute(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function DestroyChangePasswordCode($input_code){
    global $conn;
    
    try{ // Destroys code
        $query = "DELETE FROM ChangePasswordRequest WHERE changePassword_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_code);
        $stmt->execute(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}

function DestroySessionToken($input_token){
    global $conn;
    
    try{ // Destroys token
        $query = "DELETE FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_token);
        $stmt->execute(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }
}
?>