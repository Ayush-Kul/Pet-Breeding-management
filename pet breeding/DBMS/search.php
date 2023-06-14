<?php
$insert= false;

if(isset($_POST['search'])){
    $server="localhost";
    $username="root";
    $password ="";

    $con=mysqli_connect($server,$username,$password);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if(!$con){
        die("Connection to database failed due to".mysqli_connect_error);
    }
    $result=null;
    $loc = $_POST['search'];
    $sql ="select * from `petmanage`.`clinic` where location like '$loc';";   
    $result=$con->query($sql);
    if($con->query($sql)== true)
    {
        $insert= true;
    }
    else{
        echo "Error : $sql <br> $con->error"; 
    }
    $con->close();
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>
		Welcome User
	</title>
	
	<meta name="viewport"
		content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		
		/* styling navlist */
		#navlist {
			background-color: #FF7722;
			position: absolute;
			width: 100%;
		}
		
		/* styling navlist anchor element */
		#navlist a {
			float:left;
			display: block;
			color: #f2f2f2;
			text-align: center;
			padding: 12px;
			text-decoration: none;
			font-size: 15px;
		}
		.navlist-right{
			float:right;
		}

		/* hover effect of navlist anchor element */
		#navlist a:hover {
			background-color: #ddd;
			color: black;
		}
		
		/* styling search bar */
		.search input[type=text]{
			width:300px;
			height:25px;
			border-radius:25px;
			border: none;

		}
		
		.search{
			float:right;
			margin:7px;

		}
		
		.search button{
			background-color: #FF7722;
			color: #f2f2f2;
			float: right;
			padding: 5px 10px;
			margin-right: 16px;
			font-size: 12px;
			border: none;
			cursor: pointer;
		}
		.sb{
			border-radius:12px;
    font-size: 26px;
    color: #ffffff;
    padding: 40px;
    background-color: brown;
}
.sb button {
		background-color: skyblue;
		color: #f2f2f2;
		padding: 10px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		font-size: 14px;
		margin-top: 10px;
	}

	.sb button:hover {
		background-color: yellow;
	}
.bg{
  width: 100%;
  position: absolute ;
  z-index: -1;
  opacity: 0.6}
  .content{
	font-size: 25px;
	
  }
	</style>
</head>

<body>
	<img class="bg" src="9.png" alt="Dog">
	<!-- Navbar items -->
	<div id="navlist">
		<a href="index.html">Home</a>
		<a href="contact.html">Contact Us</a>
		<a href="login.html">LogOut</a>

		<!-- search bar right align -->
		<div class="search">

			<form action="search.php" method="post">
				<input type="text"
					placeholder="Enter Your Area"
					name="search">
				<button>
					<i class="fa fa-search"
						style="font-size: 18px;">
					</i>
				</button>

			</form>
		</div>

	</div>
	<?php
	if (!empty($result)) {
		if ($result->num_rows > 0) {
			echo '<div class="sb">';
			while ($row = $result->fetch_assoc()) {
				echo "<p>Name: " . $row["Name"] . "<br>";
				echo "Location: " . $row["Location"] . "<br>";
				echo "Contact: " . $row["Contact"] . "</p>";
				echo "<form method='get' action='bookapp.php'>";
				echo "<input type='hidden' name='cid' value='" . $row["Clinic_id"] . "'>";
				echo "<button type='submit'>Book Appointment</button>";
				echo "</form>";
			}
			echo '</div>';
		} else {
			echo '<div class="sb">No results found.</div>';
		}
	}
	?>


	<!-- logo with tag -->
	<div class="content">
		<h1 style="color:#FF7722; padding-top:40px;">
			Purrfect Breeds
		</h1>

		<b>
			A Portal for Best Breeds
		</b>



		<p>
			Find The Best mate for your pet

			Safe RELABLE and Accurate Results
		</p>


	</div>
</body>
</html>