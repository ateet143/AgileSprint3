<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei
// Date      : Oct 2022
?>
<?php
include_once('include/db_connect_pdo.php');

// Define variables and initialize with empty values
$artstyle_primarykey = "";
$artstyle = "";
$artstyle_err = "";

// Processing form data when form is submitted
if (isset($_POST["artstyle"]) && !empty($_POST["artstyle"])) {
    $artstyle = $_POST["artstyle"];
    $artstyle_primarykey = $_POST["artstyle_primarykey"];

    // Validate art style
    $input_artstyle = trim($_POST["artstyle"]);
    if (empty($input_artstyle)) {
        $artstyle_err = "Please enter art style.";
        //} elseif(!filter_var($input_artstyle, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        //    $artstyle_err = "Please enter a valid art style.";
    } else {
        $artstyle = $input_artstyle;
    }

    // Check input errors before updating in database
    if (empty($artstyle_err)) {
        try {
            // Art style may have been changed and the Style record must be updated with the preserved primarykey            
            $sql = "UPDATE Style SET ArtStyle=? WHERE ArtStyle=?";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute([$artstyle, $artstyle_primarykey])) {
                    // Record updated successfully. Redirect to landing page
                    header("location: StyleTable.php");
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
    if (isset($_GET["artstyle"]) && !empty(trim($_GET["artstyle"]))) {
        // Get URL parameter
        $artstyle = trim($_GET["artstyle"]);
        try {
            $sql = "SELECT * FROM Style WHERE ArtStyle=?";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute([$artstyle])) {
                    // One style record found
                    if ($stmt->rowCount() == 1) {
                        $row = $stmt->fetch();
                        $artstyle = $row["ArtStyle"];
                        $artstyle_primarykey = $artstyle;
                    }
                } else {
                    //Redirect to landing page					
                    header("location: StyleTable.php");
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
        <title>Update Style</title>

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
                        <h2 class="mt-5">Update Style</h2>
                        <p>Please edit the details and submit to update this style record.</p>
                        <!-- Avoid PHP_SELF exploit -->                        
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <div class="form-group">
                                <label>Art Style</label>
                                <input type="text" name="artstyle" class="form-control <?php echo (!empty($artstyle_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $artstyle; ?>">
                                <span class="invalid-feedback"><?php echo $artstyle_err; ?></span>
                            </div>                                                    
                            <!-- Preserve primary key value -->
                            <input type="hidden" name="artstyle_primarykey" value="<?php echo $artstyle_primarykey; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">				
                            <!-- Cancel button to redirect to landing page -->
                            <a href="StyleTable.php" class="btn btn-secondary ml-2">Cancel</a>
                            <?php include_once('include/db_close_pdo.php'); ?>
                        </form>
                    </div>
                </div>        
            </div>    
        </main> 
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>