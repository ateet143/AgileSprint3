<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<?php
include_once('include/db_connect_pdo.php');

// Define variables and initialize with empty values
$artistname_primarykey = "";
$artistname = $yearborn = $yeardeath = "";
$artistname_err = $yearborn_err = $yeardeath_err = "";
$is_thumbnail = false;
$is_image = false;

// Processing form data when form is submitted
if (isset($_POST["artistname"]) && !empty($_POST["artistname"])) {
    $artistname = $_POST["artistname"];
    $artistname_primarykey = $_POST["artistname_primarykey"];

    // Validate artist name
    $input_artistname = trim($_POST["artistname"]);
    if (empty($input_artistname)) {
        $artistname_err = "Please enter artist name.";
        //} elseif(!filter_var($input_artistname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        //    $artistname_err = "Please enter a valid artist name.";
    } else {
        $artistname = $input_artistname;
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
    $is_thumbnail = false;
    if (isset($_FILES['thumbnail'])) {
        if (is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
            $thumbnailData = file_get_contents($_FILES['thumbnail']['tmp_name']);
            $is_thumbnail = true;
        }
    }

    // Check image file is loaded
    $is_image = false;
    if (isset($_FILES['image'])) {
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $imageTrue = $imageData;
            $is_image = true;
        }
    }

    // Check input errors before updating in database
    if (empty($artistname_err) && empty($yearborn_err) && empty($yeardeath_err)) {
        try {
            // Artist name may have been changed and the Artist record must be updated with the preserved primarykey
            // update thumbnail and image
            if ($is_thumbnail && $is_image) {
                $sql = "UPDATE Artist SET ArtistName=?,BornYear=?,DeathYear=?,Thumbnail=?,Image=? WHERE ArtistName=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$artistname, $yearborn, $yeardeath, $thumbnailData, $imageData, $artistname_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: ArtistTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                // update thumbnail
            } else if ($is_thumbnail && !$is_image) {
                $sql = "UPDATE Artist SET ArtistName=?,BornYear=?,DeathYear=?,Thumbnail=? WHERE ArtistName=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$artistname, $yearborn, $yeardeath, $thumbnailData, $artistname_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: ArtistTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                // update image
            } else if (!$is_thumbnail && $is_image) {
                $sql = "UPDATE Artist SET ArtistName=?,BornYear=?,DeathYear=?,Image=? WHERE ArtistName=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$artistname, $yearborn, $yeardeath, $imageData, $artistname_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: ArtistTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                // update all but thumbnail and image
            } else {
                $sql = "UPDATE Artist SET ArtistName=?,BornYear=?,DeathYear=? WHERE ArtistName=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$artistname, $yearborn, $yeardeath, $artistname_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: ArtistTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
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
    if (isset($_GET["artistname"]) && !empty(trim($_GET["artistname"]))) {
        // Get URL parameter
        $artistname = trim($_GET["artistname"]);
        try {
            $sql = "SELECT * FROM Artist WHERE ArtistName=?";
            if ($stmt = $pdo->prepare($sql)) {
                if ($stmt->execute([$artistname])) {
                    // One artist record found
                    if ($stmt->rowCount() == 1) {
                        $row = $stmt->fetch();
                        $artistname = $row["ArtistName"];
                        $yearborn = $row["BornYear"];
                        $yeardeath = $row["DeathYear"];                        
                        $artistname_primarykey = $artistname;
                    }
                } else {
                    //Redirect to landing page					
                    header("location: ArtistTable.php");
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
        <title>Update Artist</title>

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
                        <h2 class="mt-5">Update Artist</h2>
                        <p>Please edit the details and submit to update this artist record.</p>
                        <!-- Avoid PHP_SELF exploit -->
                        <!-- Specify enctype="multipart/form-data for file upload -->
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Artist Name</label>
                                <input type="text" name="artistname" class="form-control <?php echo (!empty($artistname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $artistname; ?>">
                                <span class="invalid-feedback"><?php echo $artistname_err; ?></span>
                            </div>                        
                            <div class="form-group">
                                <label>Year Born</label>
                                <input type="text" name="yearborn" class="form-control <?php echo (!empty($yearborn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $yearborn; ?>" maxlength="4" size="4" style="width: 120px;">
                                <span class="invalid-feedback"><?php echo $yearborn_err; ?></span>
                            </div>      												
                            <div class="form-group">
                                <label>Year Death</label>
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
                            <!-- Preserve primary key value -->
                            <input type="hidden" name="artistname_primarykey" value="<?php echo $artistname_primarykey; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">				
                            <!-- Cancel button to redirect to landing page -->
                            <a href="ArtistTable.php" class="btn btn-secondary ml-2">Cancel</a>
                            <?php include_once('include/db_close_pdo.php'); ?>
                        </form>
                    </div>
                </div>        
            </div>    
        </main> 
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>