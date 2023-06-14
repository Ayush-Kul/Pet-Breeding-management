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
    $Contact = $_POST['contact'];
    $Breed = $_POST['breed'];
    $Price=$_POST['price'];
    $sql ="INSERT INTO `petmanage`.`buyer` (`Name`, `Phone_num`, `Breed`,`Price`) VALUES ( '$name', '$Contact', '$Breed','$Price');";   

    if($con->query($sql)== true)
    {
        $insert= true;
    }
    else{
        echo "Error : $sql <br> $con->error"; 
    }
    $con->close();
}
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
<img class="bg" src="3.png" alt="Dog">
<h1>Hello User</h1>
<h2>We'll Help you find the best Buddy</h2>
<?php
        if($insert==true){
        echo "<p class='Submitmsg'>Thanks for submitting your details we will contact you on the number you provided </p>";
        }
        ?>
<div class="container">
  <form action="buyer.php" method="post">

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
      <label for="contact">Contact No.</label>
    </div>
    <div class="col-75">
      <input type="text" id="contact" name="contact" placeholder="Your Contact no..">
    </div>
  </div>


  <div class="row">
    <div class="col-25">
      <label for="breed">Breed</label>
    </div>
    <div class="col-75">
      <input type="text" id="breed" name="breed" placeholder="Your required Breed..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="price">Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="price " name="price" placeholder="What is your budget..">
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


