<?php
include('database_connection.php');

// Check if attendance_id is set
if(isset($_REQUEST['attendance_id'])) {
    $aid = $_REQUEST['attendance_id'];
    
    $stmt = $connection->prepare("SELECT * FROM attendance_records WHERE attendance_id=?");
    $stmt->bind_param("i", $aid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['attendance_id'];
        $u = $row['employee_id'];
        $y = $row['date'];
    } else {
        echo "attendance_records not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in attendance_records</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update attendance_records form -->
    <h2><u>Update Form of attendance_records</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="eid">employee_id:</label>
        <input type="number" name="eid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="d">date:</label>
        <input type="date" name="d" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $employee_id = $_POST['eid'];
    $date = $_POST['d'];
    
    
    // Update the attendance_records in the database
    $stmt = $connection->prepare("UPDATE attendance_records SET employee_id=?, date=? WHERE attendance_id=?");
    $stmt->bind_param("sdi", $employee_id, $date, $hid);
    $stmt->execute();
    
    // Redirect to attendance_records.php
    header('Location: attendance_records.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
