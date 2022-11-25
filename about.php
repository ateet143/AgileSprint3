<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="ALE TEAM">       
    <title>About</title>

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
    <!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
  </head>
  
  <body>    		    
	<?php
		include_once('include/navbar.php');
		//include_once('include/db_init_pdo.php');
	?>
	<main class="container">
	  <div class="bg-light p-3 rounded">
		<h1>About </h1> 
		<h2 class="display-6"> Welcome to Acme Arts </h1>
		<p class="lead">The leading online art gallery.</p>		
	  
		<div class="bg-info p-2 bg-opacity-25 rounded">
		   <p class="fw-semibold">Student 1: Ellena Begg</p>
		   <p class="fw-semibold">Student 2: Atit Singh</p>
		   <p class="fw-semibold">Student 3: Low Kok Wei</p>		   
		   <p class="fw-bold">Assessment : Task Three</p>
		   <p class="fw-bold"> TurnKey LAMP Server : http://192.168.56.93/index.php</p>
		</div>
	  </div>
	</main>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>      
  </body>
</html>