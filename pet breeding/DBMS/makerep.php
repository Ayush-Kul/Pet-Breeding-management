<?php
// connect to the database
$db = new mysqli('localhost', 'root', '', 'petmanage');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['animal_name'], $_POST['species'], $_POST['symptoms'], $_POST['diagnosis'], $_POST['treatment'], $_POST['Type'])) {
    // get form data
    $animal_name = $_POST['animal_name'];
    $species = $_POST['species'];
    $symptoms = $_POST['symptoms'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];
    $Type = $_POST['Type'];

    // insert data into database
    $query = "INSERT INTO reports (animal_name, species, symptoms, diagnosis, treatment, Type)
              VALUES ('$animal_name', '$species', '$symptoms', '$diagnosis', '$treatment', '$Type')";

    if ($db->query($query) === true) {
        echo "Value inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }

    // fetch pet_id from pets table
    $query = "SELECT pet_id, gender FROM pets WHERE name='$animal_name'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pet_id = $row['pet_id'];
        $gender = $row['gender'];

        if ($gender == 'male' || $gender == 'Male') {
            // insert pet_id into m_pet table
            $query = "INSERT INTO m_pet (pet_id, Type) VALUES ('$pet_id', '$Type')";
            $db->query($query);
        } else if($gender == 'female' || $gender == 'Female') {
            // insert pet_id into f_pet table
            $query = "INSERT INTO f_pet (pet_id, Type) VALUES ('$pet_id', '$Type')";
            $db->query($query);
        }
    }
}

// close the database connection
$db->close();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Vet Reports</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

header {
  background-color: #2ecc71;
  color: #fff;
  padding: 20px;
  text-align: center;
}

h1 {
  margin: 0;
}

nav {
  background-color: #f2f2f2;
  border-bottom: 1px solid #ccc;
  display: flex;
  justify-content: space-between;
  padding: 10px 20px;
}

nav a {
  color: #333;
  text-decoration: none;
  font-weight: bold;
  padding: 10px;
}

nav a:hover {
  color: #000;
}

main {
  margin: 20px;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

form input[type="text"],
form textarea {
  border: 1px solid #ccc;
  padding: 5px;
  width: 100%;
}

form textarea {
  height: 100px;
}

form button[type="submit"] {
  background-color: #2ecc71;
  border: none;
  color: #fff;
  padding: 10px 20px;
  margin-top: 10px;
  cursor: pointer;
}

form button[type="submit"]:hover {
  background-color: #27ae60;
}

footer {
  background-color: #333;
  color: #fff;
  padding: 20px;
  text-align: center;
}

/* Additional animal care-themed styles */

header {
  background-image: url("animal-care-bg.jpg");
  background-size: cover;
  padding: 50px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

nav {
  background-color: #f9f5f1;
}

nav a {
  color: #333;
  font-size: 16px;
  transition: color 0.3s ease-in-out;
}

nav a:hover {
  color: #e67e22;
}

main {
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

table {
  border: 1px solid #ccc;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

th {
  background-color: #f9f5f1;
}

form label {
  color: #e67e22;
  font-size: 16px;
}

form input[type="text"],
form textarea {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  font-size: 14px;
}

form button[type="submit"] {
  background-color: #e67e22;
  color: #fff;
  font-size: 16px;
  border-radius: 4px;
  padding: 10px 20px;
  transition: background-color 0.3s ease-in-out;
}

form button[type=submit]:hover {
  background-color: #000;
  cursor: pointer;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
}

  </style>
</head>
<body>
  <header>
    <h1>Vet Reports</h1>
  </header>

  <nav>
    <a href="Admin.html">Home</a>
    <a href="contact.html">Contact</a>
    <a href="login.html">Log out</a>
  </nav>

  <main>
    <h2>Add Report</h2>

    <form method="POST" action="makerep.php">
      <label for="animal_name">Animal Name:</label>
      <input type="text" name="animal_name" id="animal_name" required>

      <label for="species">Species:</label>
      <input type="text" name="species" id="species" required>

      <label for="symptoms">Symptoms:</label>
      <textarea name="symptoms" id="symptoms"></textarea>

      <label for="diagnosis">Diagnosis:</label>
      <textarea name="diagnosis" id="diagnosis"></textarea>

      <label for="treatment">Treatment:</label>
      <textarea name="treatment" id="treatment"></textarea>
      <label for="Type">Status:</label>
<input type="text" name="Type" id="Type" required>
      <button type="submit">Submit</button>
    </form>

    <h2>Reports</h2>

    <?php
    // connect to database
    $db = new mysqli('localhost', 'root', '', 'petmanage');

    // get reports
    $query = "SELECT * FROM reports ORDER BY created_at DESC";
    $result = $db->query($query);

    // display reports
    if ($result->num_rows > 0) {
      echo '<table>';
echo '<thead><tr><th>Animal Name</th><th>Species</th><th>Symptoms</th><th>Diagnosis</th><th>Treatment</th><th>Date</th></tr></thead>';
      echo '<tbody>';
      while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['animal_name'] . '</td>';
        echo '<td>' . $row['species'] . '</td>';
        echo '<td>' . $row['symptoms'] . '</td>';
        echo '<td>' . $row['diagnosis'] . '</td>';
        echo '<td>' . $row['treatment'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
    } else {
      echo 'No reports found.';
    }

    // close database connection
    $db->close();
    ?>
  </main>

  <footer>
    &copy; 2023 Vet Reports
  </footer>
</body>
</html>
