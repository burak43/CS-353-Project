<?php
	include_once 'dbconnect.php';
	session_start();
	ob_start();

	if ( !isset($_SESSION['user']))
	{
		header("Location: login.php");
		die;
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>CnC</title>

		<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

</head>
<body style="padding-top: 65px;">
   <!-- Fixed navbar -->
   <nav class="navbar navbar-inverse navbar-fixed-top">
       <div class="container">
         <div class="navbar-header">
           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="index.php">Crash&Sleep</a>
     </div>

     <div id="navbar" class="navbar-collapse collapse">
       <ul class="nav navbar-nav">
          <li class><a href="index.php">Home</a></li>
          <?php echo '<li><a href="profile.php?account_id=' . $_SESSION['user']. '" > Profile Page </a> </li>';?>
          <li><a href="detailed_search.php">Detailed Search</a></li>
          <li  class = "active"><a href="add_accommodation.php">Offer Accommodation</a></li>
          <li> <a href = "check_reservations.php"> Check Reservations </a></li> 
     </ul>
     <ul class="nav navbar-nav navbar-right">
         <?php
          					$query = "SELECT *
			  						  FROM Account 
			  						  WHERE account_ID = {$_SESSION['user']};";
			  				$result = mysqli_query($db , $query) or die("Could not execute query");
		  					$row  = mysqli_fetch_array($result);
		  					$logged_in_name = $row['name'];
	          	?>
	          			<li> <p class="navbar-text"> Logged in as <?php echo "$logged_in_name" ?>,  </p></li>
	          			<li><a href="logout.php">Log out</a></li>
	          	
     </ul>
 </div>
</div>
</nav>


<div class="container">
<h3> Offer Accommodation </h3>
	<form action="add_accomm_to_db.php" method="post" role="form">

	<!-- ENTER ADDRESS -->
	<div class="row">
		<div class="col-md-10">
			<div class="form-group">
				<label for="city">Address:</label>
				<textarea class="form-control" rows="4" id ="address" name="address" placeholder="Enter the address of accommodation"
					 style="resize: none" required></textarea>
			</div>
		</div>
	</div>
	
	<!-- ENTER CITY -->
	<div class="row">
		<div class="col-md-5">
			<div class="form-group">
				<label for="city">City:</label>
				<input type="text" class="form-control" id ="city" name="city" list="cityList" placeholder="Choose or enter a city" required>
					<datalist id="cityList">
						<option value="">Cities</option>
						<?php
			
						$req = "SELECT city FROM Address;";
						$result = mysqli_query($db, $req);
						$city = [];
						while ($tuple = mysqli_fetch_assoc($result)) {
							$city[] = $tuple['city'];
				
						}
						$city = array_unique($city);
						sort($city);
						foreach ($city as $value) {
							echo "<option value=\"$value\">$value</option>";
						}
				
						?>
					</datalist>
			</div>
		</div>
		<!-- ENTER DISTRICT-->
		<div class="col-md-5">
			<div class="form-group">
				<label for="city">District:</label>
				<input type="text" class="form-control" id="district-list" name="district-list" list="districtList" 
						placeholder="Choose or enter a district" required>
					<datalist id="districtList">
						<option value="">Districts</option>
					</datalist>
				</select>
			</div>
		</div>
	</div>

	<!-- CALENDAR DATE PICKER-->	
	<div class="row">				
		<div class='col-md-5'>
			<label for="datetimepicker6">Available From:</label>
				<div class="form-group">
					<div class='input-group date'  id='datetimepicker6' name="datetimepicker6">
						<input type='text' class="form-control" name="datetimepicker6" required/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
					</div>
				</div>
		</div>
							
		<div class='col-md-5'>
			<label for="datetimepicker7">Until:</label>
			<div class="form-group">
				<div class='input-group date' required id='datetimepicker7' name="datetimepicker7">
					<input type='text' class="form-control" name="datetimepicker7" required/>
					<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
	</div>

	<!-- ENTER NUMBER OF PEOPLE -->				
	<div class="row">
		<div class="col-md-4">
			<div class="form-group" required>
				<label for="num_of_people">Maximum number of guests:</label>
				<select class="form-control" id="num_of_people" name="num_of_people" required>
					<option></option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
				</select>
			</div>
		</div>
	<!-- ENTER TYPE -->	
		<div class="col-md-3">
			<div class="form-group" required>
				<label for="accom_type">Accommodation type:</label>
				<select class="form-control" id="accom_type" name="accom_type" required>
					<option></option>
					<option value="0">House</option>
					<option value="1">Room</option>
				</select>
			</div>
		</div>
		<!-- ENTER PRICE -->
		<div class="col-md-3">
			<div class="form-group">
				<label for="price">Price:</label>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" class="form-control" id="price" name="price" placeholder="Enter price per night"required>
				</div>
		  </div>
		</div>
	</div>
	
	<!-- CHOOSE AMENITIES -->
	<p><b>Select amenities:</b></p>
	<div class="form-group"> 
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="wifi" name="wifi"> Wi-Fi
		</label>
		<label class="form-check-inline check">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="ethernet" name="ethernet"> Ethernet
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="tv" name="tv"> TV
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="cable" name="cable"> Cable TV
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="kitchen" name="kitchen"> Kitchen
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="washing" name="washing"> Washing Machine
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="dryer" name="dryer"> Dryer
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="bathtub" name="bathtub"> Bathtub
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="hangers" name="hangers"> Hangers
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="iron" name="iron"> Iron
		</label>
		<label class="form-check-inline">
			<input class="form-check-input" style="margin:10px;" type="checkbox" id="parking" name="parking"> Free Parking
		</label>
	</div>
	
	<!-- SUBMIT BUTTON -->
	<div class="row">
		<div class="col-md-5">
			<div class="form-group">
				<button class="btn btn-primary " name="submit" type="submit">Add offering</button>
			</div>
		</div>
	</div>
	</form>
</div>
	

		
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script type="text/javascript">
									$(function () {
										$('#datetimepicker6').datetimepicker({
											format: 'YYYY-MM-DD',
											useCurrent: false,
										});
										$('#datetimepicker7').datetimepicker({
										
											format: 'YYYY-MM-DD',
											useCurrent: false,
										});
										$("#datetimepicker6").on("dp.change", function (e) {
											$('#datetimepicker7').data("DateTimePicker").minDate(e.date);
										});
										$("#datetimepicker7").on("dp.change", function (e) {
											$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
										});
										
									});
							</script>	
<script type="text/javascript">
		$(document).ready(function() {
			$('#city').on('change', function() {
				var city = $(this).val();
				if (city) {
					$.ajax({
						type:'POST',
						url:"getcities.php",
						data:'city='+city,
						success:function(data) {
							$('#districtList').html(data);
						}	
					});
				}
				else {
					$('#district-list').html('<option value="">');
				}
			});	
		});
	</script>
</body>
</html>
<?php ob_end_flush(); ?>
