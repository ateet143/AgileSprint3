<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei
// Date      : Oct 2022
?>
<?php

include_once('include/db_connect_pdo.php');	
 
// Define variables and initialize with empty values
$media = "";
$media_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate media
    $input_media = trim($_POST["media"]);
    if(empty($input_media)){
        $media_err = "Please enter a media.";
    } elseif(!filter_var($input_media, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $media_err = "Please enter a valid media.";
    } else{
        $media = $input_media;
    }
            
    // Check input errors before inserting in database
    if(empty($media_err)){
		try {        
			$sql = "INSERT INTO Media (Medium) VALUES (?)";			 
			if($stmt = $pdo -> prepare($sql)){
				if($stmt->execute([$media])){
					// Records created successfully. Redirect to landing page
					header("location: MediaTable.php");
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
    <title>Create Art Medium</title>

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
                    <p>Please fill this form and submit to add media record to the database.</p>
					<!-- Avoid PHP_SELF exploit -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Art Medium</label>
                            <input type="text" name="media" class="form-control <?php echo (!empty($media_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $media; ?>">
                            <span class="invalid-feedback"><?php echo $media_err;?></span>
                        </div>                        
                        <input type="submit" class="btn btn-primary" value="Submit">
						<!-- Cancel button to redirect to landing page -->
                        <a href="MediaTable.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>    
	</main> 
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
  </body>
</html>