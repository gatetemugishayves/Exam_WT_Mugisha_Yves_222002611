<?php
include('database_connection.php');

// Check if employee_id is set
if (isset($_REQUEST['employee_id'])) {
    $employee_id = $_REQUEST['employee_id'];
    
    $stmt = $connection->prepare("SELECT * FROM employees WHERE employee_id=?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $department_id = $row['department_id'];
        $start_date = $row['start_date'];
        $job_title = $row['job_title'];
    } else {
        echo "Employee not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Employees</title>
    <!-- JavaScript validation and content load for update or modify data -->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update employee form -->
    <h2><u>Update Form for Employees</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="id">ID:</label>
        <input type="number" id="id" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <br><br>

        <label for="did">Department ID:</label>
        <input type="number" id="did" name="did" value="<?php echo isset($department_id) ? $department_id : ''; ?>">
        <br><br>

        <label for="sd">Start Date:</label>
        <input type="text" id="sd" name="sd" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
        <br><br>

        <label for="jt">Job Title:</label>
        <input type="text" id="jt" name="jt" value="<?php echo isset($job_title) ? $job_title : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $id = $_POST['id'];
    $department_id = $_POST['did'];
    $start_date = $_POST['sd'];
    $job_title = $_POST['jt'];
    
    // Update the employees in the database
    $stmt = $connection->prepare("UPDATE employees SET id=?, department_id=?, start_date=?, job_title=? WHERE employee_id=?");
    $stmt->bind_param("iissi", $id, $department_id, $start_date, $job_title, $employee_id);
    $stmt->execute();
    
    // Redirect to employees.php
    header('Location: employees.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
