<?php
include('database_connection.php');

// Check if department_id is set
if (isset($_REQUEST['department_id'])) {
    $department_id = $_REQUEST['department_id'];
    
    $stmt = $connection->prepare("SELECT * FROM departments WHERE department_id=?");
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $department_id = $row['department_id'];
        $department_name = $row['department_name'];
        $location = $row['location'];
    } else {
        echo "Department not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Departments</title>
    <!-- JavaScript validation and content load for update or modify data -->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update departments form -->
    <h2><u>Update Form for Departments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="dn">Department Name:</label>
        <input type="text" id="dn" name="dn" value="<?php echo isset($department_name) ? $department_name : ''; ?>">
        <br><br>

        <label for="lt">Location:</label>
        <input type="text" id="lt" name="lt" value="<?php echo isset($location) ? $location : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $department_name = $_POST['dn'];
    $location = $_POST['lt'];
    
    // Update the departments in the database
    $stmt = $connection->prepare("UPDATE departments SET department_name=?, location=? WHERE department_id=?");
    $stmt->bind_param("ssi", $department_name, $location, $department_id);
    $stmt->execute();
    
    // Redirect to departments.php
    header('Location: departments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
