<?php
include('database_connection.php');

// Check if leave_id is set
if (isset($_REQUEST['leave_id'])) {
    $leave_id = $_REQUEST['leave_id'];
    
    $stmt = $connection->prepare("SELECT * FROM leaves WHERE leave_id=?");
    $stmt->bind_param("i", $leave_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_id = $row['employee_id'];
        $leave_type = $row['leave_type'];
    } else {
        echo "Leave not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Leave Record</title>
    <!-- JavaScript validation and content load for update or modify data -->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update leaves form -->
    <h2><u>Update Form for Leaves</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="eid">Employee ID:</label>
        <input type="text" id="eid" name="eid" value="<?php echo isset($employee_id) ? $employee_id : ''; ?>">
        <br><br>

        <label for="lt">Leave Type:</label>
        <input type="text" id="lt" name="lt" value="<?php echo isset($leave_type) ? $leave_type : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $employee_id = $_POST['eid'];
    $leave_type = $_POST['lt'];
    
    // Update the leaves in the database
    $stmt = $connection->prepare("UPDATE leaves SET employee_id=?, leave_type=? WHERE leave_id=?");
    $stmt->bind_param("ssi", $employee_id, $leave_type, $leave_id);
    $stmt->execute();
    
    // Redirect to leaves.php
    header('Location: leaves.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
$connection->close();
?>
