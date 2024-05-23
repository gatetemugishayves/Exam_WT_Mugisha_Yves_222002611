<?php
include('database_connection.php');

// Check if department_id is set
if (isset($_REQUEST['department_id'])) {
    $department_id = $_REQUEST['department_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM departments WHERE department_id=?");
    $stmt->bind_param("i", $department_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="department_id" value="<?php echo $department_id; ?>">
            <input type="submit" value="Delete">
        </form>
    </body>
    </html>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    }
    $stmt->close();
} else {
    echo "department_id is not set.";
}

$connection->close();
?>
