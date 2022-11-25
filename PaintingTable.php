<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="ALE TEAM">    
    <title>Painting Table</title>

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
    <!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
  </head>
  
  <body>    		    
  <?php
	include_once('include/navbar.php');
	include_once('include/db_connect_pdo.php');	
  ?>
	<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="float-start">Paintings</h2>
						<!-- Button to add new painting -->
						<a href="CreatePainting.php" class="btn btn-success float-end">Add New Painting</a>
                    </div>
  <?php		
					try {
						$sql = "SELECT Painting.Id, Painting.Title, Painting.Year, Painting.Thumbnail, Artist.ArtistName,Style.ArtStyle,Media.Medium
						FROM Painting
						LEFT JOIN Artist ON Painting.ArtistId = Artist.Id
						LEFT JOIN Style  ON Painting.ArtStyleId = Style.Id
						LEFT JOIN Media  ON Painting.MediumId = Media.Id
						Order BY Painting.Id";
						$result = $pdo->query($sql);			
						if ($result->rowCount()>0){
						// Fill the table with rows of painting record
  ?>						
						<table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th> 								
                                    <th>Title</th>                           
									<th>Year</th>
									<th>Artist</th>
									<th>Style</th>
									<th>Medium</th>
									<th>Record</th>
                                </tr>
                            </thead>
                            <tbody>
								
  <?php						while($row = $result->fetch()){					?>
								<tr>
								    <td><?=$row['Id']?></td>
                                    <td><?=$row['Title']?></td>
									<td><?=$row['Year']?></td>
									<td><?=$row['ArtistName']?></td>
									<td><?=$row['ArtStyle']?></td>
									<td><?=$row['Medium']?></td>
									<td>                        
										<!-- Button to update this painting -->
                                        <a href="UpdatePainting.php?&Id=<?=$row['Id']?>" class="btn btn-secondary">Update</a>
										<!-- Button to delete this painting --><!-- Added send Title to Delete page EDIT by Ellena Begg -->
                                        <a href="DeletePainting.php?&Id=<?=$row['Id']?>&Title=<?=$row['Title']?>" class="btn btn-secondary">Delete</a>
                                    </td>
                                </tr>			
  <?php				
							}
							unset($result);
  ?>
							</tbody>                        
                        </table>

  <?php									 
						}  
					} catch(PDOException $e) {
						die("ERROR: Could not able to execute $sql. " . $e->getMessage());
					}
	include_once('include/db_close_pdo.php');			
  ?>					
				</div>
			</div>
		</div>
	</div>	
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
  </body>
</html>