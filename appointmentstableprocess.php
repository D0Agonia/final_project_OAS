<?php
// Your database connection code here

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $appointmentType = $_POST["appointment_type"];
    $status = $_POST["status"];

    try {
        $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM your_table WHERE role = :role AND appointment_type = :appointmentType AND status = :status";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':appointmentType', $appointmentType);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        echo '<table data-toggle="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Time</th>';
        echo '<th>Appointee</th>';
        echo '<th>Role</th>';
        echo '<th>Appointment Type</th>';
        echo '<th>Document Requested</th>';
        echo '<th>Purpose / Comments</th>';
        echo '<th>Status</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['column1']}</td>";
            echo "<td>{$row['column2']}</td>";
            // Add more columns as needed
            echo "</tr>";
        }

        echo '</tbody>';
        echo '</table>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
}
?>
