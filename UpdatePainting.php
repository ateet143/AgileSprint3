<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei
// Date      : Oct 2022
?>
<?php
include_once('include/db_connect_pdo.php');

// Define variables and initialize with empty values
$title_primarykey = "";
$title = $year = $name = $style = $media = "";
$name_temp = $style_temp = $media_temp = "";
$title_err = $year_err = $name_err = $style_err = $media_err = "";
$is_thumbnail = false;
$is_image = false;

// Processing form data when form is submitted
if (isset($_POST["title"]) && !empty($_POST["title"])) {
    $title = $_POST["title"];
    $title_primarykey = $_POST["title_primarykey"];

    // Validate title
    $input_title = trim($_POST["title"]);
    if (empty($input_title)) {
        $title_err = "Please enter a title.";
        //} elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        //    $title_err = "Please enter a valid title.";
    } else {
        $title = $input_title;
    }

    // Validate year
    $input_year = trim($_POST["year"]);
    if (empty($input_year)) {
        $year_err = "Please enter the year.";
    } elseif (!ctype_digit($input_year)) {
        $year_err = "Please enter a positive integer value.";
    } else {
        $year = $input_year;
    }

    // Validate name	
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please select an artist.";
    } else {
        //$name = $input_name;
        $strArray = explode('-', $input_name);
        $name = $strArray[0];
        $name_temp = $input_name;
    }

    // Validate style
    $input_style = trim($_POST["style"]);
    if (empty($input_style)) {
        $style_err = "Please select art style.";
    } else {
        //$style = $input_style;
        $strArray = explode('-', $input_style);
        $style = $strArray[0];
        $style_temp = $input_style;
    }

    // Validate media
    $input_media = trim($_POST["media"]);
    if (empty($input_media)) {
        $media_err = "Please select a media.";
    } else {
        //$media = $input_media;
        $strArray = explode('-', $input_media);
        $media = $strArray[0];
        $media_temp = $input_media;
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
    if (empty($title_err) && empty($year_err)) {
        try {
            // Title may have been changed and the Painting record must be updated with the preserved primarykey
            // update thumbnail and image
            if ($is_thumbnail && $is_image) {
                $sql = "UPDATE Painting SET Title=?,Year=?,ArtistId=?,ArtStyleId=?,MediumId=?,Thumbnail=?,Image=? WHERE Id=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$title, $year, $name, $style, $media, $thumbnailData, $imageData, $title_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: PaintingTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                // update thumbnail
            } else if ($is_thumbnail && !$is_image) {
                $sql = "UPDATE Painting SET Title=?,Year=?,ArtistId=?,ArtStyleId=?,MediumId=?,Thumbnail=? WHERE Id=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$title, $year, $name, $style, $media, $thumbnailData, $title_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: PaintingTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                // update image
            } else if (!$is_thumbnail && $is_image) {
                $sql = "UPDATE Painting SET Title=?,Year=?,ArtistId=?,ArtStyleId=?,MediumId=?,Image=? WHERE Id=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$title, $year, $name, $style, $media, $imageData, $title_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: PaintingTable.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                // update all but thumbnail and image
            } else {
                $sql = "UPDATE Painting SET Title=?,Year=?,ArtistId=?,ArtStyleId=?,MediumId=? WHERE Id=?";
                if ($stmt = $pdo->prepare($sql)) {
                    if ($stmt->execute([$title, $year, $name, $style, $media, $title_primarykey])) {
                        // Record updated successfully. Redirect to landing page
                        header("location: PaintingTable.php");
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
    if (isset($_GET["Id"]) && !empty(trim($_GET["Id"]))) {
        // Get URL parameter
        $paintingId = trim($_GET["Id"]);
        try {
           $sql = "SELECT Painting.Title, Painting.Year,Painting.ArtistId, Artist.ArtistName,Painting.ArtStyleId,Style.ArtStyle,Painting.MediumId,Media.Medium,Painting.Thumbnail
						FROM Painting
						LEFT JOIN Artist ON Painting.ArtistId = Artist.Id
						LEFT JOIN Style  ON Painting.ArtStyleId = Style.Id
						LEFT JOIN Media  ON Painting.MediumId = Media.Id
						Where Painting.Id = ?";  	
			if($stmt = $pdo -> prepare($sql)){
				if($stmt->execute([$paintingId])){
					// One painting record found
					if ($stmt->rowCount()==1){
						$row = $stmt->fetch();
						$title = $row["Title"];
						$year = $row["Year"];
						$artistId = $row["ArtistId"];
						$name = $row["ArtistName"];
						$styleId =  $row["ArtStyleId"];
						$style = $row["ArtStyle"]; 
						$mediumId =  $row["MediumId"];
						$media = $row["Medium"];						
						$title_primarykey = $paintingId;
					}
				} else{
					//Redirect to landing page					
					header("location: PaintingTable.php");
					exit();					
				}
			}
			unset($stmt);
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    }

    // Initialise name array
    $name_array = array();
    $sql = "SELECT * FROM Artist ORDER BY Id";
    $result = $pdo->query($sql);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch()) {
            $name_array[] = $row["Id"] . "-" . $row["ArtistName"];
        }
        unset($result);
    }

    // Initialise style array
    $style_array = array();
    $sql = "SELECT * FROM Style ORDER BY Id";
    $result = $pdo->query($sql);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch()) {
            $style_array[] = $row["Id"] . "-" . $row["ArtStyle"];
        }
        unset($result);
    }

    // Initialise media array
    $media_array = array();
    $sql = "SELECT * FROM Media ORDER BY Id";
    $result = $pdo->query($sql);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch()) {
            $media_array[] = $row["Id"] . "-" . $row["Medium"];
        }
        unset($result);
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
        <title>Update Painting</title>

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
                        <h2 class="mt-5">Update Painting</h2>
                        <p>Please edit the details and submit to update this painting record.</p>
                        <!-- Avoid PHP_SELF exploit -->
                        <!-- Specify enctype="multipart/form-data for file upload -->
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                                <span class="invalid-feedback"><?php echo $title_err; ?></span>
                            </div>                        
                            <div class="form-group">
                                <label>Year</label>
                                <input type="text" name="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                                <span class="invalid-feedback"><?php echo $year_err; ?></span>
                            </div>      												
                            <label for="name">Select an artist</label>
                            <select name="name" class="form-select">													
                                <?php
                                // Allow to select option when page is first loaded
                                if (empty($name_temp)) {
                                    echo '<option value=" ' . $artistId . '" selected> ' . $name . '</option>';
                                    foreach ($name_array as $item) {
										// display only Artist's Name value, not ID. EDIT by Ellena
										echo '<option value=" ' . $item[0] . '"> ' . substr($item,2) . '</option>';
                                    }
                                } else {
                                    // Fix to selected value after form is submitted
                                    echo '<option value=" ' . $name . '" selected> ' . $name . '</option>';
                                }
                                ?>                        
                            </select>			
                            <label for="style">Select art style</label>
                            <select name="style" class="form-select">
                                <?php
                                // Allow to select option when page is first loaded
                                if (empty($style_temp)) {
                                    echo '<option value=" ' . $styleId . '" selected> ' . $style . '</option>';
                                    foreach ($style_array as $item) {
										// display only Style's Name value, not ID. EDIT by Ellena
                                        echo '<option value=" ' . $item[0] . '"> ' . substr($item,2) . '</option>';
                                    }
                                } else {
                                    // Fix to selected value after form is submitted
                                    echo '<option value="' . $style . '" selected>' . $style . '</option>';
                                }
                                ?>
                            </select>
                            <label for="media">Select media</label>
                            <select name="media" class="form-select">							
                                <?php
                                // Allow to select option when page is first loaded
                                if (empty($media_temp)) {
                                    echo '<option value=" ' . $mediumId . '" selected> ' . $media . '</option>';
                                    foreach ($media_array as $item) {
										// display only Media's Name value, not ID. EDIT by Ellena
                                        echo '<option value=" ' . $item[0] . '"> ' . substr($item,2) . '</option>';
                                    }
                                } else {
                                    // Fix to selected value after form is submitted
                                    echo '<option value="' . $media . '" selected>' . $media . '</option>';
                                }
                                ?>
                            </select>						
                            <div class="form-group">
                                <label>Upload thumbnail file</label>
                                <input type="file" name="thumbnail" class="full-width">                            
                            </div>      						
                            <div class="form-group">
                                <label>Upload image file</label>
                                <input type="file" name="image" class="full-width">                            
                            </div>      						
                            <!-- Preserve primary key value -->
                            <input type="hidden" name="title_primarykey" value="<?php echo $title_primarykey; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">				
                            <!-- Cancel button to redirect to landing page -->
                            <a href="PaintingTable.php" class="btn btn-secondary ml-2">Cancel</a>
                            <?php include_once('include/db_close_pdo.php'); ?>
                        </form>
                    </div>
                </div>        
            </div>    
        </main> 
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>