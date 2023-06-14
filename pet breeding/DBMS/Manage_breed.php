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

// Query the first table
$sql1 = "SELECT m.*, p.Age, p.breed
         FROM m_pet m
         JOIN pets p ON m.pet_id = p.pet_id
         WHERE m.Type IS NOT NULL
         ORDER BY m.Date";

$result1 = mysqli_query($con, $sql1);

if (!$result1) {
    die("Error executing the query: " . mysqli_error($con));
}

if (mysqli_num_rows($result1) == 0) {
    echo "No records found in the m_pet table.";
}

// Query the second table
$sql2 = "SELECT f.*, p.Age, p.breed
          FROM f_pet f
          JOIN pets p ON f.pet_id = p.pet_id
          WHERE f.Type IS NOT NULL
          ORDER BY f.Date";

$result2 = mysqli_query($con, $sql2);

if (!$result2) {
    die("Error executing the query: " . mysqli_error($con));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];

    // Prepare and execute SQL procedure call
    $stmt = $con->prepare("CALL addtobreed(?, ?)");
    $stmt->bind_param("ss", $input1, $input2);
    $stmt->execute();

    if ($stmt->errno) {
        die("Error executing stored procedure: " . $stmt->error);
    }

    $stmt->close();

    // Reload the page to update the table
    header("Location: Manage_breed.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage the Breedings</title>
    <!--<link rel="stylesheet" type="text/css" href="styles2.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('10.png');
            /* other CSS properties for the background image */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .table {
            flex-basis: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #D6EEEE;
            
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .form-container {
            margin-top: 20px;
            text-align: center;
        }

        input[type='text'] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type='submit'] {
            width: auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type='submit']:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff0000;
            margin-top: 10px;
        }

        .success-message {
            color: #008000;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <img class="bg" >
    <div class="container">
        <div class="table">
            <table border="1">
                <tr>
                    <th colspan="6">Male pets</th>
                </tr>
                <tr>
                    <th>MP_id</th>
                    <th>pet_id</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Age</th>
                    <th>Breed</th>
                </tr>
                <?php while($row1 = $result1->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row1['MP_id']; ?></td>
                        <td><?php echo $row1['pet_id']; ?></td>
                        <td><?php echo $row1['Type']; ?></td>
                        <td><?php echo $row1['Date']; ?></td>
                        <td><?php echo $row1['Age']; ?></td>
                        <td><?php echo $row1['breed']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="table">
            <table border="1">
                <tr>
                    <th colspan="6">Female pets</th>
                </tr>
                <tr>
                    <th>FP_id</th>
                    <th>pet_id</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Age</th>
                    <th>Breed</th>
                </tr>
                <?php while($row2 = $result2->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row2['FP_id']; ?></td>
                        <td><?php echo $row2['pet_id']?></td>
                        <td><?php echo $row2['Type']; ?></td>
                        <td><?php echo $row2['Date']; ?></td>
                        <td><?php echo $row2['Age']; ?></td>
                        <td><?php echo $row2['breed']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <form method="post" action="Manage_breed.php" class="form-container">
        <label for="input1">Enter the pet id for suitable male:</label>
        <input type="text" name="input1" id="input1">
        <label for="input2">Enter the pet id for suitable female:</label>
        <input type="text" name="input2" id="input2">
        <input type="submit" value="Submit">
    </form>
</body>
</html>