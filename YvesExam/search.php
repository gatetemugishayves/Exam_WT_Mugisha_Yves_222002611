<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
include('database_connection.php');


    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'attendance_records' => "SELECT date FROM attendance_records WHERE date LIKE '%$searchTerm%'",
        'departments' => "SELECT location FROM departments WHERE location LIKE '%$searchTerm%'",
        'employees' => "SELECT job_title FROM employees WHERE job_title LIKE '%$searchTerm%'",
        'holidays' => "SELECT Holiday_name FROM holidays WHERE Holiday_name LIKE '%$searchTerm%'",
        'leaves' => "SELECT leave_type FROM leaves WHERE leave_type LIKE '%$searchTerm%'",
        'overtime_rules' => "SELECT min_hours FROM overtime_rules WHERE min_hours LIKE '%$searchTerm%'",
        'pay_rates' => "SELECT pay_type FROM pay_rates WHERE Transactpay_typeionType LIKE '%$searchTerm%'",
        'shifts' => "SELECT shift_name FROM shifts WHERE shift_name LIKE '%$searchTerm%'",
'timesheets' => "SELECT regular_hours FROM timesheets WHERE regular_hours LIKE '%$searchTerm%'"
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
