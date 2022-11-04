<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Low, Kok Wei
// Date      : Oct 2022
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Low Kok Wei">    
    <title>Painting</title>

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
    <!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
</head>
  
<body>    		    
<?php
	include_once('include/navbar.php');
	include_once('include/db_connect_pdo.php');
    //	if (isset($_GET['Id'])){
	//Filter to remove tags and encode special characters
	//$title = filter_var($_GET['title'], FILTER_SANITIZE_STRING);    line comment by Atit 
	//Assign the Id to the variable paintingId                        line added by Atit
	$paintingId = $_GET['Id'];                                        //line added by Atit   
	    
	try {
		//$sql = "SELECT * FROM Painting where Title = '$title'";     line comment by Atit
		$sql = "SELECT Painting.Title, Painting.Year, Painting.Image, Artist.ArtistName,Style.ArtStyle,Media.Medium
					FROM Painting
					LEFT JOIN Artist ON Painting.ArtistId = Artist.Id
					LEFT JOIN Style  ON Painting.ArtStyleId = Style.Id
					LEFT JOIN Media  ON Painting.MediumId = Media.Id
					WHERE Painting.Id = $paintingId";       //Line added by Atit
		$result = $pdo->query($sql);			
		} catch(PDOException $e) {
			die("ERROR: Could not able to execute $sql. " . $e->getMessage());
		}
	    //} else {
	    //	exit('Painting does not exist');
	    //}
	
?>
  	<main class="container">
	    <div class="bg-light p-3 rounded">
		    <h1>Painting</h1> 
<?php		
 			if ($result->rowCount()>0)
            {				
				echo "<div class=\"row\">";
				$row = $result->fetch()
?>				
				<div class="card-columns">
					<div class="card">		
						<!-- base64 encoding of image data from database -->
						<img class="card-img-top" src="data:image/png;base64, <?php echo base64_encode($row['Image']); ?>" alt="Card image cap">
						<div class="card-body">
							<h5 class="card-title">Title : <?=$row['Title']?></h5>
							<p class="card-text">Year : <?=$row['Year']?></p>
							<p class="card-text">Artist : <?=$row['ArtistName']?></p>
							<p class="card-text">Style : <?=$row['ArtStyle']?></p>
							<p class="card-text">Media : <?=$row['Medium']?></p>
						</div>						  
				    </div>					
<?php			
				unset($result);
				echo "</div>";
			} else {
?>					
				<div class="alert alert-warning " role="alert">				  				  
					Painting title not found <?php echo $title;?> 
				</div>
<?php
			}
			include_once('include/db_close_pdo.php');			
?>
			</div>
		</div>
	</main>  
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
  </body>
</html>