<?php
require_once 'database_functions.php';
require_once 'functions.php';

if(isset($_GET['control_number']) && isset($_GET['lName'])){
    $control_number = sanitizeInput($_GET['control_number']);
    $lName = sanitizeInput($_GET['lName']);

    if(verifyAppointment($control_number, $lName == false)){
        header("Location: ../error_message/error403");
        logError("ERROR: Invalid GET parameters in view-appointment_page");
    }

    global $conn;

    $appointment = array();

    $AppointmentDocument = fetchTable('AppointmentDocument');
    $AppointmentType = fetchTable('AppointmentType');
    $AuthenticationID = fetchTable('AuthenticationID');
    $TypeDocRelationship = fetchTable('TypeDocRelationship');

    $query = "SELECT *FROM AppointmentList WHERE control_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $control_number);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    foreach ($result as $row) {
        // Merge the row array into the collapsed array
        $appointment = array_merge_recursive($appointment, $row);
    }

    $query = "SELECT *FROM UserDetails WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment['user_id']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    $displayAuthName;
    for($i = 0; $i < count($AuthenticationID); $i++){
      if($AuthenticationID[$i]['auth_abbreviation'] == $appointment['auth_abbreviation']){
        $displayAuthName = $AuthenticationID[$i]['auth_name'];
      }
    }

    $typeNames = [];
    $docNames = [];

    foreach ($appointment['typeDoc_relationship_id'] as $index => $relationshipId) {
        if ($index === 0) {
            $typeNames[] = $appointmentType[$relationshipId - 1]['type_name'];
        } else {
            $typeNames[] = 'Document Request';
        }
    }

    foreach ($appointment['typeDoc_relationship_id'] as $relationshipId) {
        foreach ($typeDocRelationship as $relationship) {
            if ($relationship['doc_abbreviation'] === $appointmentDocument[$relationshipId - 1]['doc_abbreviation']) {
                $docNames[] = $appointmentDocument[$relationshipId - 1]['doc_name'];
                break;
            }
        }
    }

    $displayAppointmentType;
    $displayDocumentRequested;
    for($i = 0; $i < count($typeNames); $i++){
        if($i == $appointment['typeDoc_relationship_id']){
            $displayAppointmentType = $typeNames[$i];
            break;
        }
    }
}
else{
    header("Location: ../error_message/error500");
    logError("ERROR: GET parameters not found in view-appointment_page");
}
?>