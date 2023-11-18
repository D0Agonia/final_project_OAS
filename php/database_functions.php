<?php
require_once 'db_connect.php';

function insertCredentials($input_kldID, $input_password) {
    global $conn;

    if (!searchKLDID($input_kldID)) {
        // Generates salt, while ensuring no such other salt exists
        do{
            $input_salt = bin2hex(random_bytes(16));

            $query = "SELECT salt_password FROM UserCredentials WHERE salt_password = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_salt);
            $stmt->execute(); $stmt->store_result();

            $salt_count = $stmt->num_rows;
        } while ($salt_count > 0);

        $input_hashPassword = hash('sha256', $input_password . $input_salt);

        // Insertion into database
        $query = "INSERT INTO UserCredentials (kld_id, hash_password, salt_password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query); $stmt->bind_param("sss", $input_kldID, $input_hashPassword, $input_salt);
        $stmt->execute();
        
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

function insertDetails($input_kldID, $input_firstname) {
    global $conn;

}

function insertGuest(){
    global $conn;

    // Generates otp, while ensuring no such other otp exists
    do{
        $otp = bin2hex(random_bytes(3));

        $query = "SELECT otp_code FROM GuestCredentials WHERE otp_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $otp);
        $stmt->execute(); $stmt->store_result();

        $otp_count = $stmt->num_rows;
    } while($otp_count > 0);

    // Insertion into database
    $query = "INSERT INTO GuestCredentials(otp_code, otp_expiration) VALUES(?, NOW() + INTERVAL 1 HOUR)";
    $stmt = $conn->prepare($query); $stmt->bind_param("s", $otp);
    $stmt->execute();
    
    $stmt->close();
    return $otp;
}

function requestPasswordChange($input_email){
    global $conn;

    // Fetches kld_id from UserDetails tied to the input email
    $query = "SELECT kld_id FROM UserDetails WHERE email = ?";
    $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_email);
    $stmt->execute(); $stmt->store_result();
    $user_kldID = $stmt->fetch_assoc()['kld_id'];

    // Counts number of changePassword_code tied to the kld_id
    $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE kld_id = ?";
    $stmt = $conn->prepare($query); $stmt->bind_param("s", $user_kldID);
    $stmt->execute(); $stmt->store_result();
    $code_count = $stmt->num_rows;

    // Creates new change password code and returns it
    if(!empty($user_kldID) && $code_count == 0){
        CreateChangePasswordCode($user_kldID);

        $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE kld_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $user_kldID);
        $stmt->execute(); $stmt->store_result();
        
        $changePassword_code = $stmt->fetch_assoc()['changePassword_code'];
        
        $stmt->close();
        return $changePassword_code;
    }
    // Fetches existing change password code and returns it
    elseif(!empty($user_kldID) && $code_count > 1){
        $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE kld_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $user_kldID);
        $stmt->execute(); $stmt->store_result();
        
        $changePassword_code = $stmt->fetch_assoc()['changePassword_code'];
        
        $stmt->close();
        return $changePassword_code;
    }
    // Returns '1' if user_kldID is empty
    else{
        $stmt->close();
        return '1';
    }
}

function verifyChangePasswordCode($input_code){
    global $conn;

    $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE changePassword_code = ?";
    $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_code);
    $stmt->execute(); $stmt->store_result();

    $code_count = $stmt->num_rows;
    $stmt->close();

    if($code_count > 0) {
        return true;
    } else {
        return false;
    }
}

function verifyGuestLogin($input_email, $input_otp){
    global $conn;

    $query = "SELECT user_id FROM UserDetails WHERE email = ?";
    $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_email);
    $stmt->execute(); $stmt->store_result();
    $guest_userID = $stmt->fetch_assoc()['user_id'];

    $query = "SELECT otp_code FROM GuestCredentials WHERE user_id = ? AND otp_code = ?";
    $stmt = $conn->prepare($query); $stmt->bind_param("ss", $guest_userID, $input_otp);
    $stmt->execute(); $stmt->store_result();
    $guestLogin_count = $stmt->num_rows;

    if($guestLogin_count > 0) {
        // Creates session token and ties it to the guest account
        CreateGuestSessionToken($guest_guestID);

        // Removes otp from database, as it is a one-time use
        $query = "UPDATE GuestCredentials SET otp_code = NULL, otp_expiration = NULL WHERE otp_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_otp);
        $stmt->execute();

        // Returns session token
        $query = "SELECT session_token FROM LoginTokens WHERE guest_id = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $guest_guestID);
        $stmt->execute(); $stmt->store_result();
        $token = $stmt->fetch_assoc()['session_token'];

        $stmt->close();
        return $token;
    }
    // Returns '1' if 
    else{
        $stmt->close();
        return '1';
    }
}

function searchKLDID($input_kldID) {
    global $conn;

    // Simple database search
    $query = "SELECT kld_id FROM UserCredentials WHERE kld_id = ?";
    $stmt = $conn->prepare($query); $stmt->bind_param("s", $input_kldID);
    $stmt->execute(); $stmt->store_result();

    $kldID_count = $stmt->num_rows;
    $stmt->close();

    if($kldID_count > 0) {
        return true;
    } else {
        return false;
    }
}

function CreateChangePasswordCode($input_kldID) {
    global $conn;

    // Generates change password code, while ensuring no such other code exists
    do{
        $code = bin2hex(random_bytes(16));

        $query = "SELECT changePassword_code FROM ChangePasswordRequest WHERE changePassword_code = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $code);
        $stmt->execute(); $stmt->store_result();

        $code_count = $stmt->num_rows;
    } while($code_count > 0);

    // Insertion into database
    $query = "INSERT INTO ChangePasswordRequest (changePassword_code, kld_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query); $stmt->bind_param("ss", $code, $input_kldID);
    $stmt->execute();

    $stmt->close();
}

function CreateGuestSessionToken($input_guest) {
    global $conn;

    // Generates session token, while ensuring no such other token exists
    do {
        $token = bin2hex(random_bytes(16));

        $query = "SELECT session_token FROM LoginTokens WHERE session_token = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $token);
        $stmt->execute(); $stmt->store_result();

        $token_count = $stmt->num_rows;
    } while ($token_count > 0);

    // Insertion into database
    $query = "INSERT INTO LoginTokens (session_token, token_expiration, guest_id) VALUES (?, NOW() + INTERVAL 1 DAY, ?)";
    $stmt = $conn->prepare($query); $stmt->bind_param("ss", $token, $input_guest);
    $stmt->execute();

    $stmt->close();
}
?>