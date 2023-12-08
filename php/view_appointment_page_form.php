<?php
require_once 'database_functions.php';
require_once 'functions.php';

global $conn;

if(isset($_GET['control_number'])){
    $control_number = sanitizeInput($_GET['control_number']);

    if(verifyAppointment($control_number) == false || filterControlNumber($control_number) == false){
        header("Location: ../error_message/error403");
        logError("ERROR: Invalid GET parameters in view-appointment_page");
    }

    $appointment = [];

    $AppointmentDocument = fetchTable('AppointmentDocument');
    $AppointmentType = fetchTable('AppointmentType');
    $AuthenticationID = fetchTable('AuthenticationID');
    $TypeDocRelationship = fetchTable('TypeDocRelationship');

    try{
        $query = "SELECT * FROM AppointmentList WHERE control_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $control_number);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $row) {
            $typeDoc_relationship_id = $row['typeDoc_relationship_id'];
            unset($row['typeDoc_relationship_id']);
            $appointment = array_merge($appointment, $row);
            $appointment['typeDoc_relationship_id'][] = $typeDoc_relationship_id;
        }

        $query = "SELECT * FROM UserDetails WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $appointment['user_id']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    $type_id = []; $doc_abbreviation = []; $doc_name = []; $type_name = [];

    // Obtains the Appointment Type Name and the Documents Requested Name of the appointment
    for($i = 0; $i < count($appointment['typeDoc_relationship_id']); $i++){
        for($j = 0; $j < count($TypeDocRelationship); $j++){
            if($appointment['typeDoc_relationship_id'][$i] == $TypeDocRelationship[$j]['relationship_id']){
                $type_id[$i] = $TypeDocRelationship[$j]['type_id'];
                $doc_abbreviation[$i] = $TypeDocRelationship[$j]['doc_abbreviation'];
                break;
            }
        }
        for($j = 0; $j < count($AppointmentDocument); $j++){
            if($doc_abbreviation[$i] == $AppointmentDocument[$j]['doc_abbreviation']){
                $doc_name[$i] = $AppointmentDocument[$j]['doc_name'];
                break;
            }
        }
        for($j = 0; $j < count($AppointmentType); $j++){
            if($type_id[$i] == $AppointmentType[$j]['type_id']){
                $type_name[$i] = $AppointmentType[$j]['type_name'];
                break;
            }
        }
    }
    for($i = 0; $i < count($AuthenticationID); $i++){
        if($appointment['auth_abbreviation'] == $AuthenticationID[$i]['auth_abbreviation']){
            $auth_name = $AuthenticationID[$i]['auth_name'];
            break;
        }
    }
}
else{
    header("Location: ../error_message/error500");
    logError("ERROR: GET parameters not found in view-appointment_page");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["home_button"])){
    $control_number = sanitizeInput($_GET['control_number']);
    if(filterControlNumber($control_number) == false){
        header("Location: ../error_message/error403");
        logError("ERROR: Invalid GET parameters in view-appointment_page");
    }

    try{
        $query = "DELETE FROM AppointmentList WHERE control_number = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $control_number);
        $stmt->execute(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    header("Location: index");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reschedule_button"])){
    header("Location: reschedule-page?control_number=" . $_GET['control_number']);
}
?>