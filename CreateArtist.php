<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<?php
include_once('include/db_connect_pdo.php');

// Define variables and initialize with empty values
$name = $yearborn = $yeardeath = "";
$name_err = $yearborn_err = $yeardeath_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate year born
    $input_yearborn = trim($_POST["yearborn"]);
    if (empty($input_yearborn)) {
        $yearborn_err = "Please enter the year born.";
    } elseif (!ctype_digit($input_yearborn)) {
        $yearborn_err = "Please enter a positive integer value.";
    } else {
        $yearborn = $input_yearborn;
    }

    // Validate year death
    $input_yeardeath = trim($_POST["yeardeath"]);
    if (empty($input_yeardeath)) {
        $yeardeath_err = "Please enter the year death.";
    } elseif (!ctype_digit($input_yeardeath)) {
        $yeardeath_err = "Please enter a positive integer value.";
    } else {
        $yeardeath = $input_yeardeath;
    }

    // Check thumbnail file is loaded
    if (isset($_FILES['thumbnail'])) {
        if (is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
            $thumbnailData = file_get_contents($_FILES['thumbnail']['tmp_name']);
        }
    }

    // Check image file is loaded
    if (isset($_FILES['image'])) {
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
        }
    }
    // Check input errors before inserting in database
    if (empty($name_err) && empty($yearborn_err) && empty($yeardeath_err)) {
        try {
            $sql = "INSERT INTO Artist (ArtistName, BornYear, DeathYear,Thumbnail,Image) VALUES (?,?,?,?,?)";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute([$name, $yearborn, $yeardeath, $thumbnailData, $imageData])) {
                    // Records created successfully. Redirect to landing page
                    header("location: ArtistTable.php");
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
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Low Kok Wei">    
        <title>Create Artist</title>

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
                        <h2 class="mt-5">Create a New Artist</h2>
                        <p>Please fill in this form and submit to add new artist record to the database.</p>
                        <!-- Avoid PHP_SELF exploit -->
                        <!-- Specify enctype="multipart/form-data for file upload -->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Artist Name</label>
                                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                                <span class="invalid-feedback"><?php echo $name_err; ?></span>
                            </div>                        
                            <div class="form-group">
                                <label>Year born</label>
                                <input type="text" name="yearborn" class="form-control <?php echo (!empty($yearborn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $yearborn; ?>" maxlength="4" size="4" style="width: 120px;">
                                <span class="invalid-feedback"><?php echo $yearborn_err; ?></span>
                            </div>  
                            <div class="form-group">
                                <label>Year of death</label>
                                <input type="text" name="yeardeath" class="form-control <?php echo (!empty($yeardeath_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $yeardeath; ?>" maxlength="4" size="4" style="width: 120px;">
                                <span class="invalid-feedback"><?php echo $yeardeath_err; ?></span>
                            </div>  
                            <div class="form-group">
                                <label>Upload thumbnail file</label>
                                <input type="file" name="thumbnail" class="full-width">                            
                            </div>      						
                            <div class="form-group">
                                <label>Upload image file</label>
                                <input type="file" name="image" class="full-width">                            
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <!-- Cancel button to redirect to landing page -->
                            <a href="ArtistTable.php" class="btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>    
        </main> 
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>