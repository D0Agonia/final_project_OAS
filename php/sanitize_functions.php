<?php
require_once 'database_functions.php';
require_once 'functions.php';

function sanitizeInfoDetails($data){
    // Runs inputs through regex filters
    if(empty($data['fname']) || empty($data['lname'])){
        return json_encode(['processed' => false, 'error_message' => 'Missing Name Information']);
    }
    elseif(filterName($data['fname']) == false || filterName($data['lname']) == false || filterName($data['mname']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid Name Format']);
    }
    elseif(empty($data['email'])){
        return json_encode(['processed' => false, 'error_message' => 'Missing Email Information']);
    }
    elseif(filter_var($data['email'], FILTER_VALIDATE_EMAIL) == false || filterEmail($data['email']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid Email Format']);
    }
    elseif(!empty($data['contact_no']) && filterPhoneNumber($data['contact_no']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid Contact Number Format']);
    }
    elseif(filterName($data['userType']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Hidden Inputs Tampered']);
    }
    elseif($data['userType'] == 'STUDENT' && filterID($data['student-id']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid Student ID Format']);
    }
    elseif($data['userType'] == 'STUDENT' && !(preg_match('/^KLD$/', $data['idType']) || empty($data['identification']))){
        return json_encode(['processed' => false, 'error_message' => 'Hidden Inputs Tampered']);
    }
    elseif($data['userType'] == 'GUEST' && filterGuest($data['guest-id']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid Guest ID Format']);
    }
    elseif($data['userType'] == 'GUEST' && $data['idType'] == 'no-id'){
        return json_encode(['processed' => false, 'error_message' => 'Please select an ID Type']);
    }
    elseif($data['userType'] == 'GUEST' && filterComment($data['idType']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid ID Type Format']);
    }
    elseif($data['userType'] == 'GUEST' && filterAlphanumeric($data['identification']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid ID Identification Format']);
    }
    elseif(filterName($data['appointmentType']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Hidden Inputs Tampered']);
    }
    elseif(filterName($data['appointmentType']) == true && $data['appointmentType'] == 'NONE'){
        return json_encode(['processed' => false, 'error_message' => 'Please select an Appointment Type']);
    }
    elseif(filterLoop('/^[a-zA-Z]*$/', $data['selectedDocuments']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Hidden Inputs Tampered']);
    }
    elseif(filterName($data['appointmentType']) == true && $data['appointmentType'] == 'DOCREQ' && $data['selectedDocuments'] == NULL){
        return json_encode(['processed' => false, 'error_message' => 'Please select a Document to request']);
    }
    elseif(filterName($data['appointmentType']) == true && $data['appointmentType'] == 'INFOCEN' && $data['selectedDocuments'] != NULL){
        return json_encode(['processed' => false, 'error_message' => 'No documents to be requested for Information Center']);
    }
    elseif(empty($data['comment'])){
        return json_encode(['processed' => false, 'error_message' => 'Please write your purpose of visit/comment']);
    }
    elseif(filterComment($data['comment']) == false){
        return json_encode(['processed' => false, 'error_message' => 'Invalid characters present in purpose of visit/comment']);
    }
    else{
        return json_encode(['processed' => true]);
    }
}
?>