<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei
// Date      : Oct 2022
?>
<?php

include_once('include/db_connect_pdo.php');	
 
// Define variables and initialize with empty values
$style = "";
$style_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate style
    $input_style = trim($_POST["style"]);
    if(empty($input_style)){
        $style_err = "Please enter a style.";
    } elseif(!filter_var($input_style, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $style_err = "Please enter a valid style.";
    } else{
        $style = $input_style;
    }
            
    // Check input errors before inserting in database
    if(empty($style_err)){
		try {        
			$sql = "INSERT INTO Style (ArtStyle) VALUES (?)";			 
			if($stmt = $pdo -> prepare($sql)){
				if($stmt->execute([$style])){
					// Records created successfully. Redirect to landing page
					header("location: StyleTable.php");
					exit();
				} else{
					echo "Something went wrong. Please try again later.";
				}
			}
			unset($stmt);
		} catch(PDOException $e) {
			die("ERROR: Could not able to execute $sql. " . $e->getMessage());
		}			
    }        
	include_once('include/db_close_pdo.php');    
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Low Kok Wei">    
    <title>Create Art Style</title>

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
    <!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
  </head>
  
  <body>    		    
  <?php
	include_once('include/navbar.php');	
  ?>
	<main class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add style record to the database.</p>
					<!-- Avoid PHP_SELF exploit -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Art Style</label>
                            <input type="text" name="style" class="form-control <?php echo (!empty($style_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $style; ?>">
                            <span class="invalid-feedback"><?php echo $style_err;?></span>
                        </div>                        
                        <input type="submit" class="btn btn-primary" value="Submit">
						<!-- Cancel button to redirect to landing page -->
                        <a href="StyleTable.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>    
	</main> 
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
  </body>
</html>