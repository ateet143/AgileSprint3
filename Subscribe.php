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
	  <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
			   <?php exit();?>
        <?php } ?>

		<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
			 <?php exit();?>
     	<?php } ?>
	  <h1>Subscription Form</h1>

	  	<form action="subscribe_check.php" method="post">
		  <div class="form-group w-50">
    			<label for="FfirstName">First Name</label>
   				<input type="text" class="form-control" id="FfirstName" name="FfirstName">
				   <?php if (isset($_GET['errorFirstName'])) { ?>
     		      <span class="error"><?php echo $_GET['errorFirstName']; ?></span><?php } ?>

   				
 		 </div>
	     <div class="form-group w-50">
    			<label for="FlastName">Last Name</label>
   				<input type="text" class="form-control" id="FlastName" name="FlastName" >
				   <?php if (isset($_GET['errorLastName'])) { ?>
     		<span class="error"><?php echo $_GET['errorLastName']; ?></span><?php } ?>
				
 		 </div>

  		 <div class="form-group w-50">
    			<label for="FEmail">Email address</label>
   				<input type="email" class="form-control" id="FEmail" name="FEmail" aria-describedby="emailHelp" >
   				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				<?php if (isset($_GET['errorEmail'])) { ?>
     		    <span class="error"><?php echo $_GET['errorEmail']; ?></span><?php } ?>
 		 </div>
		 <br>
		 <fieldset class="border p-2  w-50">
		 <legend>Choose subscription:</legend>
 			<div class="form-check">
   				<input type="checkbox" class="form-check-input" id="FcheckNewsLetter" name="FcheckNewsLetter" value="1" checked >
   				<label class="form-check-label" for="FcheckNewsLetter">Monthly Newsletter</label>
 			</div>

			<div class="form-check">
   				<input type="checkbox" class="form-check-input" id="FcheckBreakingNews" name="FcheckBreakingNews" value="1" checked >
   				<label class="form-check-label" for="FcheckBreakingNews">Breaking News</label>
				<?php if (isset($_GET['errorCheckBox'])) { ?>
     		    <span class="error"><?php echo $_GET['errorCheckBox']; ?></span><?php } ?>
 			</div>
		
 			<button type="submit" class="btn btn-primary my-2">Subscribe</button><br>
		 </fieldset>
			 <a href="index.php" class="ca">Already Subscribed?</a>
		</form>
	  </div>
	</main>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>      
  </body>
</html>