<?php
// Connect to the database
$server = "localhost";
$username = "root";
$password = "";
$dbname = "petmanage";

$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    die("Connection to the database failed due to " . mysqli_connect_error());
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST['update'])) {
    $vetIds = $_POST['Vet_id'];
    $dates = $_POST['Date'];
    $times = $_POST['Time'];
    
    $count = count($vetIds);
    for ($i = 0; $i < $count; $i++) {
        $id = $_POST['id'][$i];
        $VID = $vetIds[$i];
        $Date = $dates[$i];
        $time = $times[$i];
        
        // Update the row in the "appointment" table
        $sql = "UPDATE appointment SET Vet_id='$VID', Date='$Date', Time='$time' WHERE App_id='$id'";
        if (mysqli_query($con, $sql)) {
            // Move the updated row to the "approved_requests" table
            $moveSql = "INSERT INTO approved_request (Request_id, Clinic_id, Breeder_id, Vet_id, Date, Time)
                        SELECT App_id, Clinic_id, Breeder_id, Vet_id, Date, Time FROM appointment WHERE App_id='$id'";
            if (mysqli_query($con, $moveSql)) {
                // Delete the row from the "appointment" table
                $deleteSql = "DELETE FROM appointment WHERE App_id='$id'";
                if (mysqli_query($con, $deleteSql)) {
                    echo "Record updated successfully and moved to approved requests";
                } else {
                    echo "Error deleting record: " . mysqli_error($con);
                }
            } else {
                echo "Error moving record to approved requests: " . mysqli_error($con);
            }
        } else {
            echo "Error updating record: " . mysqli_error($con);
        }
    }
}

// Query the database for all pending requests
$sqlPending = "SELECT * FROM appointment WHERE Vet_id IS NULL";
$resultPending = mysqli_query($con, $sqlPending);
if (!$resultPending) {
    die("Query to the database failed due to " . mysqli_error($con));
}

// Query the database for all approved requests
$sqlApproved = "SELECT * FROM approved_request";
$resultApproved = mysqli_query($con, $sqlApproved);
if (!$resultApproved) {
    die("Query to the database failed due to " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Appointment Management</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <form method="post">
    <h1>Pending Requests</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Clinic ID</th>
        <th>Breeder ID</th>
        <th>Vet ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Action</th>
      </tr>
      <?php
      // Loop through all rows in the result and display them in a table
      if (mysqli_num_rows($resultPending) > 0) {
          while ($row = mysqli_fetch_assoc($resultPending)) {
            echo "<tr>";
            echo "<td>" . $row['App_id'] . "</td>";
            echo "<td>" . $row['Clinic_id'] . "</td>";
            echo "<td>" . $row['Breeder_id'] . "</td>";
            echo "<td><input type='text' name='Vet_id[]' value='" . $row['Vet_id'] . "'></td>";
            echo "<td><input type='date' name='Date[]' value='" . $row['Date'] . "'></td>";
            echo "<td><input type='time' name='Time[]' value='" . $row['Time'] . "'></td>";
            echo "<td>";
            echo "<input type='hidden' name='id[]' value='" . $row['App_id'] . "'>";
            echo "<input type='submit' name='update' value='Update'>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No pending requests found</td></tr>";
    }
    ?>
    </table>
    </form>
    
    <h1>Approved Requests</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Clinic ID</th>
        <th>Breeder ID</th>
        <th>Vet ID</th>
        <th>Date</th>
        <th>Time</th>
      </tr>
      <?php
      // Loop through all rows in the result and display them in a table
      if (mysqli_num_rows($resultApproved) > 0) {
          while ($row = mysqli_fetch_assoc($resultApproved)) {
              echo "<tr>";
              echo "<td>" . $row['Request_id'] . "</td>";
              echo "<td>" . $row['Clinic_id'] . "</td>";
              echo "<td>" . $row['Breeder_id'] . "</td>";
              echo "<td>" . $row['Vet_id'] . "</td>";
              echo "<td>" . $row['Date'] . "</td>";
              echo "<td>" . $row['Time'] . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No approved requests found</td></tr>";
      }
      ?>
    </table>
    </body>
    </html>
    
    <?php
    // Close the database connection
    mysqli_close($con);
    ?>
    