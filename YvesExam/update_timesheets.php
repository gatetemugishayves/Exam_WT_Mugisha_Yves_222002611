<?php
include('database_connection.php');

// Check if timesheet_id is set
if (isset($_REQUEST['timesheet_id'])) {
    $timesheet_id = $_REQUEST['timesheet_id'];
    
    $stmt = $connection->prepare("SELECT * FROM timesheets WHERE timesheet_id=?");
    $stmt->bind_param("i", $timesheet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_id = $row['employee_id'];
        $regular_hours = $row['regular_hours'];
        $overtime_hours = $row['overtime_hours'];
    } else {
        echo "Timesheet not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Timesheet Record</title>
    <!-- JavaScript validation and content load for update or modify data -->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update timesheet form -->
    <h2><u>Update Form for Timesheets</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="eid">Employee ID:</label>
        <input type="number" id="eid" name="eid" value="<?php echo isset($employee_id) ? $employee_id : ''; ?>">
        <br><br>

        <label for="rh">Regular Hours:</label>
        <input type="number" id="rh" name="rh" value="<?php echo isset($regular_hours) ? $regular_hours : ''; ?>">
        <br><br>

        <label for="oh">Overtime Hours:</label>
        <input type="number" id="oh" name="oh" value="<?php echo isset($overtime_hours) ? $overtime_hours : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $employee_id = $_POST['eid'];
    $regular_hours = $_POST['rh'];
    $overtime_hours = $_POST['oh'];
    
    // Update the timesheets in the database
    $stmt = $connection->prepare("UPDATE timesheets SET employee_id=?, regular_hours=?, overtime_hours=? WHERE timesheet_id=?");
    $stmt->bind_param("issi", $employee_id, $regular_hours, $overtime_hours, $timesheet_id);
    $stmt->execute();
    
    // Redirect to timesheets.php
    header('Location: timesheets.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
$connection->close();
?>
