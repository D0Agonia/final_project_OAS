<?php
require_once '../php/database_functions.php';
require_once '../php/functions.php';
require_once '../php/sanitize_functions.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' && $_SERVER["REQUEST_METHOD"] === "POST") {
    $control_number; $TypeDocRelationship; $typeDoc_relationship_id; $ID_FLAG; $input_ID; $DOCREQ_Values = array();
    
    // Inserts information and details, in preparation for regex
    if(isset($_POST['jsonData'])) {
        $userInput = json_decode($_POST['jsonData'], true);
    }
    else{
        echo json_encode(['processed' => false, 'error_message' => 'JSON Decoding Fail']);
        exit();
    }

    if(preg_match('/^\d{4}-\d{2}-\d{2}$/', $userInput['appointmentDate']) == true){
        echo json_encode(['processed' => false, 'error_message' => 'Please select a date']);
        exit();
    }
    elseif(filterDate($userInput['appointmentDate']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid date format (Y-m-d H:i)']);
        exit();
    }
    else{
        $userInput['fname'] = sanitizeInput($userInput['fname']);
        $userInput['mname'] = sanitizeInput($userInput['mname']);
        $userInput['lname'] = sanitizeInput($userInput['lname']);
        $userInput['email'] = sanitizeInput($userInput['email']);
        $userInput['contact_no'] = sanitizeInput($userInput['contact_no']);
        if(isset($userInput['student-id'])){
            $userInput['student-id'] = sanitizeInput($userInput['student-id']);
        }
        if(isset($userInput['guest-id'])){
            $userInput['guest-id'] = sanitizeInput($userInput['guest-id']);
        }
        $userInput['idType'] = sanitizeInput($userInput['idType']);
        $userInput['identification'] = sanitizeInput($userInput['identification']);
        $userInput['appointmentDate'] = sanitizeInput($userInput['appointmentDate']);
        $userInput['appointmentBuilding'] = sanitizeInput($userInput['appointmentBuilding']);
        $userInput['comment'] = sanitizeInput($userInput['comment']);

        $userInput = array_merge($userInput, json_decode(sanitizeInfoDetails($userInput), true));
        if($userInput['processed'] == true){
            do{ $control_number = generateNumber(13);
            } while (searchControlNumber($control_number) == true);
            $TypeDocRelationship = fetchTable("TypeDocRelationship");
            $ID_FLAG = $userInput['userType'] == 'STUDENT' ? 'UPDATE_KLD_ID' : 'UPDATE_GUEST_ID';
            $input_ID = $userInput['userType'] == 'STUDENT' ? $userInput['student-id'] : $userInput['guest-id'];
            updateDetails($input_ID, $userInput['fname'], $userInput['mname'], $userInput['lname'], $userInput['email'], $userInput['contact_no'], $ID_FLAG);
            if($userInput['appointmentType'] == 'INFOCEN'){
                insertAppointment($control_number, $input_ID, $userInput['idType'], $userInput['identification'], $userInput['appointmentDate'], $userInput['appointmentBuilding'], 1, $userInput['comment']);
            }
            elseif($userInput['appointmentType'] == 'DOCREQ'){
                for ($i = 0; $i < count($TypeDocRelationship); $i++) {            
                    if ($TypeDocRelationship[$i]['type_id'] === 'DOCREQ') {
                        $DOCREQ_Values[] = $TypeDocRelationship[$i]['doc_abbreviation'];
                    }
                }
                for($i = 0; $i < count($userInput['selectedDocuments']); $i++) {
                    for($j = 0; $j < count($DOCREQ_Values); $j++){
                        if ($DOCREQ_Values[$j] === $userInput['selectedDocuments'][$i]) {
                            $typeDoc_relationship_id = $j + 2;
                            insertAppointment($control_number, $input_ID, $userInput['idType'], $userInput['identification'], $userInput['appointmentDate'], $userInput['appointmentBuilding'], $typeDoc_relationship_id, $userInput['comment']);
                            break;
                        }
                    }
                }
            }
            echo json_encode(['processed' => true, 'control_number' => $control_number]);
        }
        DestroySessionToken($_COOKIE["session_token"]);
        deleteCookie('session_token'); deleteCookie('appointmentSession');
        exit();
    }
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>