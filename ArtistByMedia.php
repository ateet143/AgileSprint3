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
	<title>Artist by media</title>

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
	  <div class="bg-light p-3 rounded">
		<h1>Artists by Media</h1>				
			<!-- Prompt user to select a media and submit the form -->			
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
				<select name="Medium" class="form-select">
					<option selected>Select media</option>
<?php		
					try {
						$sql = "SELECT * FROM Media";
						$result = $pdo->query($sql);			
						if ($result->rowCount()>0){							
							while($row = $result->fetch()){																
								echo '<option value="'. $row["Id"].'">' .$row["Medium"].'</option>';
							}
							unset($result);
						}												
					} catch(PDOException $e) {
						die("ERROR: Could not able to execute $sql. " . $e->getMessage());
					}																		
?>
				</select>			
			<button type="submit" class="btn btn-primary" name="Select">Submit</button>
			</form>
<?php		
			//Processing selected Media after self-call is submitted
			if (isset($_POST['Select'])) {
				if(!empty($_POST['Medium'])) {
					$selected = $_POST['Medium'];
					
					try {									
						$sql = "SELECT DISTINCT(ArtistName), BornYear, DeathYear, Artist.Thumbnail                
								FROM Artist
								JOIN Painting ON Artist.ID = Painting.ArtistId						
								WHERE MediumId = $selected";
						$result = $pdo->query($sql);			
						if ($result->rowCount()>0){
										
							echo "<div class=\"row row-cols-3 g-3 p-3\">";
							while($row = $result->fetch()){ 			
							//Load artists of selected media							
?>
								<div class="card-columns">
								  <div class="card">
									<img class="card-img-top" src="data:image/png;base64, <?php echo base64_encode($row['Thumbnail']); ?>" alt="Card image cap">
									<div class="card-body">
									  <h5 class="card-title">Artist : <?= $row['ArtistName'] ?></h5>
                                       <p class="card-text">Life Span : <?= $row['BornYear'] . "-" . $row['DeathYear'] ?></p>
                                       <!-- Button to view full size image -->
                                       <a href="OneArtist.php?&artistname=<?= $row['ArtistName'] ?>" class="btn btn-primary">View</a>
									</div>
								  </div>						  
								</div>				
<?php															
							}
							unset($result);
							echo "</div>";							
						}
						else{
							echo "No Artist found for the Selected Media";
						}
						
					} catch(PDOException $e) {
						die("ERROR: Could not able to execute $sql. " . $e->getMessage());
					}
				}
			}
			include_once('include/db_close_pdo.php');		  					
?>
	</div>
	</main>  
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>