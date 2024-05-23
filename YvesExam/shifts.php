<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>our shifts</title>
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

  <header>

<body bgcolor="skyblue">
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

    <h1><u> shifts Form </u></h1>
    <form method="post" onsubmit="return confirmInsert();">
            
        <label for="sid">shift_id:</label>
        <input type="number" id="sid" name="sid"><br><br>

        <label for="sn">shift_name:</label>
        <input type="text" id="sn" name="sn"><br><br>

        <label for="st">start_time:</label>
        <input type="time" id="st" name="st" required><br><br>

        <label for="et">end_time:</label>
        <input type="time" id="et" name="et" required><br><br>
        <label for="did">department_id:</label>
        <input type="number" id="did" name="did" required><br><br>

        

        <input type="submit" name="add" value="Insert">
      

    </form>


<?php
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO shifts(shift_id, shift_name, start_time,end_time, department_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $sid, $sn, $st,$et, $did );
    // Set parameters and execute
    $sid = $_POST['sid'];
    $sn = $_POST['sn'];
    $st = $_POST['st'];
    $et = $_POST['et'];
    $did = $_POST['did'];
   
    
   
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

// SQL query to fetch data from the shifts table
$sql = "SELECT * FROM shifts";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of shifts</title>
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
    <center><h2>Table of shifts</h2></center>
    <table border="5">
        <tr> 
            <th>shift_id</th>
            <th>shift_name</th>
            <th>start_time</th>
            <th>end_time</th>
<th>department_id</th>\
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
      include('database_connection.php');

        // Prepare SQL query to retrieve all shifts
        $sql = "SELECT * FROM shifts";
        $result = $connection->query($sql);

        // Check if there are any shifts
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $sid = $row['shift_id']; // Fetch the shift_id
                echo "<tr>
                    <td>" . $row['shift_id'] . "</td>
                    <td>" . $row['shift_name'] . "</td>
                    <td>" . $row['start_time'] . "</td>
                    <td>" . $row['end_time'] . "</td>
                   <td>" . $row['department_id'] . "</td>
                    <td><a style='padding:4px' href='delete_shifts.php?shift_id=$sid'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_shifts.php?shift_id=$sid'>Update</a></td> 
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