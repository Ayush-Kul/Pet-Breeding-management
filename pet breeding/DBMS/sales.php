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
    // Get values from the form
    $id = $_POST['id'];
    $VID = $_POST['pet_id'];

    // Update the row in the "buyer" table
    $sql = "UPDATE buyer SET pet_id='$VID' WHERE Buyer_ID='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Query the database for all pending requests
$sqlPending = "SELECT * FROM buyer WHERE pet_id IS NULL";
$resultPending = mysqli_query($con, $sqlPending);
if (!$resultPending) {
    die("Query to the database failed due to " . mysqli_error($con));
}

// Query the database for all approved requests
$sqlApproved = "SELECT * FROM buyer WHERE price IS NOT NULL";
$resultApproved = mysqli_query($con, $sqlApproved);
if (!$resultApproved) {
    die("Query to the database failed due to " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sales Management</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <h1>Pending Requests</h1>
  <form method="post">
    <table>
      <tr>
        <th>Name</th>
        <th>Phone_number</th>
        <th>Breed</th>
        <th>Price</th>
        <th>Pet_id</th>
        <th>Action</th>
      </tr>
      <?php
      // Loop through all rows in the result and display them in a table
      if (mysqli_num_rows($resultPending) > 0) {
          while ($row = mysqli_fetch_assoc($resultPending)) {
              echo "<tr>";
              echo "<td>" . $row['Name'] . "</td>";
              echo "<td>" . $row['Phone_num'] . "</td>";
              echo "<td>" . $row['Breed'] . "</td>";
              echo "<td>" . $row['Price'] . "</td>";
              echo "<td><input type='text' name='pet_id' value='" . $row['pet_id'] . "'></td>";
              echo "<td>";
              echo "<input type='hidden' name='id' value='" . $row['Buyer_ID'] . "'>";
              echo "<input type='submit' name='update' value='Update'>";
              echo "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No pending requests found</td></tr>";
      }
      ?>
    </table>
  </form>
</body>
</html>
