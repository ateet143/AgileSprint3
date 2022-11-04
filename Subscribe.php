<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei,Atit,Ellena
// Date      : 4 November 2022
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Atit Singh">        
	<title>Subscribe</title>

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">       
	<!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
  </head>
  
  <body>    	
  <?php
		include_once('include/navbar.php')
  ?>	
	<main class="container">
	  <div class="bg-light p-3 rounded">
	  <h1>Subscription Form</h1>
	  	<form>
		  <div class="form-group w-50">
    			<label for="FfirstName">First Name</label>
   				<input type="text" class="form-control" id="FfirstName" >
   				
 		 </div>
	     <div class="form-group w-50">
    			<label for="FlastName">Last Name</label>
   				<input type="text" class="form-control" id="FlastName" >
   				 
 		 </div>

  		 <div class="form-group w-50">
    			<label for="FEmail">Email address</label>
   				<input type="email" class="form-control" id="FEmail" aria-describedby="emailHelp" >
   				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
 		 </div>
		 <br>
		 <p>Choose One or Both</p>
 			<div class="form-check">
   				<input type="checkbox" class="form-check-input" id="FcheckNewsLetter">
   				<label class="form-check-label" for="FcheckNewsLetter">Monthly Newsletter</label>
 			</div>

			<div class="form-check">
   				<input type="checkbox" class="form-check-input" id="FcheckBreakingNews">
   				<label class="form-check-label" for="FcheckBreakingNews">Breaking News</label>
 			</div>
 			<button type="submit" class="btn btn-primary">Subscribe</button>
		</form>
	  </div>
	</main>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>      
  </body>
</html>