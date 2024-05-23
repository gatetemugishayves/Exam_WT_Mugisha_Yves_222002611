<?php
include('database_connection.php');

// Check if Holiday_id is set
if(isset($_REQUEST['Holiday_id'])) {
    $hid = $_REQUEST['Holiday_id'];
    
    $stmt = $connection->prepare("SELECT * FROM holidays WHERE Holiday_id=?");
    $stmt->bind_param("i", $hid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Holiday_id'];
        $u = $row['Holiday_date'];
        $y = $row['Holiday_name'];
    } else {
        echo "holidays not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in holidays</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update holidays form -->
    <h2><u>Update Form of holidays</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="hod">Holiday_date:</label>
        <input type="text" name="hod" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="hn">Holiday_name:</label>
        <input type="text" name="hn" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Holiday_date = $_POST['hod'];
    $Holiday_name = $_POST['hn'];
    
    
    // Update the holidays in the database
    $stmt = $connection->prepare("UPDATE holidays SET Holiday_date=?, Holiday_name=? WHERE Holiday_id=?");
    $stmt->bind_param("ssd", $Holiday_date, $Holiday_name, $hid);
    $stmt->execute();
    
    // Redirect to holidays.php
    header('Location: holidays.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
