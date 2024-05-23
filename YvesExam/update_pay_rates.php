<?php
include('database_connection.php');

// Check if pay_rate_id is set
if(isset($_REQUEST['pay_rate_id'])) {
    $pid = $_REQUEST['pay_rate_id'];
    
    $stmt = $connection->prepare("SELECT * FROM pay_rates WHERE pay_rate_id=?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['pay_rate_id'];
        $u = $row['employee_id'];
        $y = $row['pay_type'];
        $z = $row['pay_amount'];
    } else {
        echo "pay_rates not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update new record in pay_rates</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update pay_rates form -->
    <h2><u>Update Form of pay_rates</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="eid">employee_id:</label>
        <input type="text" name="eid" value="<?php echo isset($u) ? $u : ''; ?>">
        <br><br>

        <label for="pt">pay_type:</label>
        <input type="text" name="pt" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for=pa>pay_amount:</label>
        <input type="text" name="pa" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $employee_id = $_POST['eid'];
    $pay_type = $_POST['pt'];
    $pay_amount = $_POST['pa'];
    
    // Update the pay_rates in the database
    $stmt = $connection->prepare("UPDATE pay_rates SET employee_id=?, pay_type=?, pay_amount=? WHERE pay_rate_id=?");
    $stmt->bind_param("ssii", $employee_id, $pay_type, $pay_amount, $pid);
    $stmt->execute();
    
    // Redirect to pay_rates.php
    header('Location: pay_rates.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
