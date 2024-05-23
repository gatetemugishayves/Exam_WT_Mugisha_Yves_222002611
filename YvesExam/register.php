<?php
include('database_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $activation_code = $_POST['activation_code'];

    // Hashing the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparing SQL query
    $sql = "INSERT INTO user (firstname, lastname, email, username, password, telephone, activation_code) VALUES ('$fname','$lname','$email', '$username', '$hashed_password','$telephone','$activation_code')";

    // Executing SQL query
    if ($connection->query($sql) === TRUE) {
        // Redirecting to login page on successful registration
        header("Location: login.html");
        exit();
    } else {
        // Displaying error message if query execution fails
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Closing database connection
$connection->close();
?>
