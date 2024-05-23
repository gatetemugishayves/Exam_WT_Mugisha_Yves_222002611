<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our holidays</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
      
    }
    header{
    background-color:skyblue;
}
    section{
    padding:71px;
    border-bottom: 1px solid #ddd;
    }
    footer{
    text-align: center;
    padding: 15px;
    background-color:skyblue;
    }

  </style>
  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  </head>

  <header>

<body bgcolor="green">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./images/logos.png" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./Service.html">SERVICE</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./overtime_rules.php">OVERTIME_RULES</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./holidays.php">HOLIDAYS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./pay_rates.php">PAY RATES</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./attendance_records.php">ATTENDANCE RECORDS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./shifts.php">SHIFTS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./departments.php">DEPARTMENTS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./employees.php">EMPLOYEES</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./leaves.php">LEAVES</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./timesheets.php">TIMESHEETS</a>
  </li>

  
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>

    <h1><u> holidays Form </u></h1>
    <form method="post" onsubmit="return confirmInsert();">
            
        <label for="hid">Holiday_id:</label>
        <input type="number" id="hid" name="hid"><br><br>

        <label for="hod">Holiday_date:</label>
        <input type="date" id="hod" name="hod"><br><br>

        <label for="hn">Holiday_name:</label>
        <input type="text" id="hn" name="hn" required><br><br>

  



        <input type="submit" name="add" value="Insert">
      

    </form>


<?php
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO holidays(Holiday_id, Holiday_date, Holiday_name) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $hid, $hod, $hn);
    // Set parameters and execute
    $hid = $_POST['hid'];
    $hod = $_POST['hod'];
    $hn = $_POST['hn'];
    
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<?php
include('database_connection.php');

// SQL query to fetch data from the holidays table
$sql = "SELECT * FROM holidays";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of holidays</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of holidays</h2></center>
    <table border="5">
        <tr>
            <th>Holiday_id</th>
            <th>Holiday_date</th>
            <th>Holiday_name</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
      include('database_connection.php');

        // Prepare SQL query to retrieve all holidays
        $sql = "SELECT * FROM holidays";
        $result = $connection->query($sql);

        // Check if there are any holidays
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $hid = $row['Holiday_id']; // Fetch the Holiday_id
                echo "<tr>
                    <td>" . $row['Holiday_id'] . "</td>
                    <td>" . $row['Holiday_date'] . "</td>
                    <td>" . $row['Holiday_name'] . "</td>
                    <td><a style='padding:4px' href='delete_holidays.php?Holiday_id=$hid'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_holidays.php?Holiday_id=$hid'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
</body>

    </section>


  
<footer>
  <center> 
    <marquee behavior='alternate'>
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by: @YVES GM</h2></b>
  </marquee>
  </center>
</footer>
</body>
</html>