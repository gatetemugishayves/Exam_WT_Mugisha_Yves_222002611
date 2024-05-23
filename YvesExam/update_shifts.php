<?php
include('database_connection.php');

// Check if shift_id is set
if(isset($_REQUEST['shift_id'])) {
    $sid = $_REQUEST['shift_id'];
    
    $stmt = $connection->prepare("SELECT * FROM shifts WHERE shift_id=?");
    $stmt->bind_param("i", $sid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['shift_id'];
        $u = $row['shift_name'];
        $y = $row['start_time'];
        $z = $row['end_time'];
        $w = $row['department_id'];
    } else {
        echo "shifts not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in shifts</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update shifts form -->
    <h2><u>Update Form of shifts</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="sn">shift_name:</label>
        <input type="text" name="sn" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="st">start_time:</label>
        <input type="time" name="st" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for=et>end_time:</label>
        <input type="time" name="et" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="did">department_id:</label>
        <input type="number" name="did" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $shift_name = $_POST['sn'];
    $start_time = $_POST['st'];
    $end_time = $_POST['et'];
    $department_id = $_POST['did'];
    
    // Update the shifts in the database
    $stmt = $connection->prepare("UPDATE shifts SET shift_name=?, start_time=?, end_time=?, department_id=? WHERE shift_id=?");
    $stmt->bind_param("sssii", $shift_name, $start_time, $end_time, $department_id, $sid);
    $stmt->execute();
    
    // Redirect to shifts.php
    header('Location: shifts.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
