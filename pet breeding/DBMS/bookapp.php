<?php
$insert = false;
if (isset($_GET['cid'])) {
    $id = $_GET['cid'];
    // Do something with the clinic ID
}
else{
	$id=1;
}


if (isset($_POST['name'])) {
    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server, $username, $password);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if (!$con) {
        die("Connection to database failed due to" . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $Pname = $_POST['Pname'];
    $bid = null;
    $pid = null;
    $breeder_found = false;
    $pet_found = false;

    // check if entered name is found in breeder table
    $bidi = "SELECT breeder_id FROM `petmanage`.`breeder` WHERE Name LIKE '$name'";
    $result = mysqli_query($con, $bidi);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $bid = $row['breeder_id'];
        $breeder_found = true;
    }

    // check if entered pet name is found in pets table
    $pidi = "SELECT pet_id FROM `petmanage`.`pets` WHERE Name LIKE '$Pname'";
    $result = mysqli_query($con, $pidi);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pid = $row['pet_id'];
        $pet_found = true;
    }

    // insert appointment if breeder and pet are found
	if ($breeder_found && $pet_found) {
		$sql = "INSERT INTO `petmanage`.`appointment` (Clinic_id, Pet_id, Breeder_id) VALUES ('$id', '$pid', '$bid')";
	
		if (mysqli_query($con, $sql)) {
			$insert = true;
			
			//echo "Appointment booked successfully.";
			//exit();
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}
	} //else {
		//echo "OOPS! it seems like your not on our database. Please tell us about yourself on the <a href='breeder.php'>find mate for your pet</a> page first!";
	//}
	

		


    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        h2 {
            margin-top: 0;
            text-align: center;
            color: #FF7722;
        }

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            font-size: 18px;
            color: #333;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 16px;
            resize: vertical;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #FF7722;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #e65c00;
        }

        .message {
            margin-bottom: 20px;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Book Appointment</h2>
        <?php
        if (isset($_POST['name'])) {
            // Your PHP code for handling form submission goes here
            // ...

            if ($breeder_found && $pet_found) {
                // Appointment booked successfully message
                echo '<div class="message">Appointment booked successfully.</div>';
            } else {
                // OOPS! message
                echo '<div class="message">OOPS! It seems like you\'re not in our database. Please tell us about yourself on the <a href="breeder.php">find mate for your pet</a> page first!</div>';
            }
        }
        ?>
        <form method="post" action="bookapp.php">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="Pname">Pet Name:</label>
            <input type="text" id="Pname" name="Pname" required>

            <input type="submit" value="Book Appointment" name="search">
        </form>
    </div>
</body>

</html>
