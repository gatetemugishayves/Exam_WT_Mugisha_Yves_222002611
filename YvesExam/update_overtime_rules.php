<?php
include('database_connection.php');

// Check if rule_id is set
if(isset($_REQUEST['rule_id'])) {
    $rid = $_REQUEST['rule_id'];
    
    $stmt = $connection->prepare("SELECT * FROM overtime_rules WHERE rule_id=?");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['rule_id'];
        $u = $row['department_id'];
        $y = $row['min_hours'];
        $z = $row['overtime_multiplier'];
    } else {
        echo "Overtime rule not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Overtime Rule</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update overtime_rules form -->
    <h2><u>Update Overtime Rule</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="did">Department ID:</label>
        <input type="number" name="did" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="mh">Minimum Hours:</label>
        <input type="number" name="mh" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="om">Overtime Multiplier:</label>
        <input type="number" step="0.01" name="om" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $department_id = $_POST['did'];
    $min_hours = $_POST['mh'];
    $overtime_multiplier = $_POST['om'];
    
    // Update the overtime_rules in the database
    $stmt = $connection->prepare("UPDATE overtime_rules SET department_id=?, min_hours=?, overtime_multiplier=? WHERE rule_id=?");
    $stmt->bind_param("iidi", $department_id, $min_hours, $overtime_multiplier, $rid);
    $stmt->execute();
    
    // Redirect to overtime_rules.php
    header('Location: overtime_rules.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
