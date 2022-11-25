<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<?php
include_once('include/db_connect_pdo.php');

// Define variables and initialize with empty values
$medium_primarykey = "";
$medium = "";
$medium_err = "";

// Processing form data when form is submitted
if (isset($_POST["medium"]) && !empty($_POST["medium"])) {
    $medium = $_POST["medium"];
    $medium_primarykey = $_POST["medium_primarykey"];

    // Validate medium
    $input_medium = trim($_POST["medium"]);
    if (empty($input_medium)) {
        $medium_err = "Please enter medium.";
        //} elseif(!filter_var($input_medium, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        //    $medium_err = "Please enter a valid medium.";
    } else {
        $medium = $input_medium;
    }

    // Check input errors before updating in database
    if (empty($medium_err)) {
        try {
            // Medium may have been changed and the Media record must be updated with the preserved primarykey            
            $sql = "UPDATE Media SET Medium=? WHERE Medium=?";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute([$medium, $medium_primarykey])) {
                    // Record updated successfully. Redirect to landing page
                    header("location: MediaTable.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }            
            unset($stmt);
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    }
    include_once('include/db_close_pdo.php');
} else {
// Retrive data from database when the Update page is first loaded
    if (isset($_GET["medium"]) && !empty(trim($_GET["medium"]))) {
        // Get URL parameter
        $medium = trim($_GET["medium"]);
        try {
            $sql = "SELECT * FROM Media WHERE Medium=?";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute([$medium])) {
                    // One style record found
                    if ($stmt->rowCount() == 1) {
                        $row = $stmt->fetch();
                        $medium = $row["Medium"];
                        $medium_primarykey = $medium;
                    }
                } else {
                    //Redirect to landing page					
                    header("location: MediaTable.php");
                    exit();
                }
            }
            unset($stmt);
        } catch (PDOException $e) {
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
        <title>Update Media</title>

        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
        <!-- Custom styles for this template -->
        <link href="navbar-top-fixed.css" rel="stylesheet">
    </head>

    <body>    		    
        <?php
        include_once('include/navbar.php');
        include_once('include/db_connect_pdo.php');
        ?>
        <main class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mt-5">Update Media</h2>
                        <p>Please edit the details and submit to update this media record.</p>
                        <!-- Avoid PHP_SELF exploit -->                        
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <div class="form-group">
                                <label>Medium</label>
                                <input type="text" name="medium" class="form-control <?php echo (!empty($medium_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $medium; ?>">
                                <span class="invalid-feedback"><?php echo $medium_err; ?></span>
                            </div>                                                    
                            <!-- Preserve primary key value -->
                            <input type="hidden" name="medium_primarykey" value="<?php echo $medium_primarykey; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">				
                            <!-- Cancel button to redirect to landing page -->
                            <a href="MediaTable.php" class="btn btn-secondary ml-2">Cancel</a>
                            <?php include_once('include/db_close_pdo.php'); ?>
                        </form>
                    </div>
                </div>        
            </div>    
        </main> 
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>