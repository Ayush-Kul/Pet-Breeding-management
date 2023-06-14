<?php
$insert= false;

if(isset($_POST['name'])){
    $server="localhost";
    $username="root";
    $password ="";

    $con=mysqli_connect($server,$username,$password);
    if(!$con){
        die("Connection to database failed due to".mysqli_connect_error());
    }
    
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $Fee = $_POST['FEE'];
    $sql ="INSERT INTO `petmanage`.`breeder` (`Name`, `Contact`, `Fee`) VALUES ( '$name', '$contact', '$Fee');";   

    if($con->query($sql)== true)
    {
        $insert= true;
    }
    else{
        echo "Error : $sql <br> $con->error"; 
    }
    $con->close();
}

// Reset $insert to false if the form hasn't been submitted
if(!$insert){
    $insert = false;
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}
body{
  background: #ad6c44;
  overflow: hidden;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #FF7722;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #bd591a;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row::after {
  content: "";
  display: table;
  clear: both;
}
.bg{
  width: 100%;
  position: absolute ;
  z-index: -1;
  opacity: 0.6}
/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 70%;
    margin-top: 0;
  }
}
</style>
</head>
<body>
<img class="bg" src="2.png" alt="Dog">
<h2>Breeder Info</h2>
<p>We'll find the best match for your pet..</p>
<?php
        if($insert==true){
        header("Location:pets.php");
        }
        ?>
<div class="container">
  <form action="breeder.php" method="post">

  <div class="row">
    <div class="col-25">
      <label for="yname">Your Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="name" name="name" placeholder="Your name..">
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="contact">Your Phone number</label>
    </div>
    <div class="col-75">
      <input type="text" id="contact" name="contact" placeholder="Your Phone number..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="FEE">Your fee for breeding?</label>
    </div>
    <div class="col-75">
      <input type="text" id="FEE" name="FEE" placeholder="Your Fee ..">
    </div>
  </div>

  <br>
  <div class="row">
    <input type="submit" value="Submit">
  </div>
  </form>
</div>

</body>
</html>


