<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Ellena Begg
// Date      : Nov 2022
// Desc      : Page to list all Members who have a subscription to our Monthly News Newsletter
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="List all Members who have a subscription to our Monthly Newsletter">
    <meta name="author" content="Ellena Begg">        
	<title>Monthly Subscribers</title>

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
			<h1>Monthly News Subscribers</h1> 
			<?php
			try {
				$sql = "SELECT * FROM Member WHERE MonthlyNewsletter=true ORDER BY LastName";
				$result = $pdo->query($sql);
				if ($result->rowCount() > 0) {
					?>
					<div class="row row-cols-3 g-3">
						<?php while ($row = $result->fetch()) { ?>
							<div class="card-columns">
								<div class="card" align="center">
									<div class="card-body">
										<h5 class="card-title"><?= $row['FirstName'] . ' ' . $row['LastName'] ?></h5>
										<!-- <p class="card-text">Email : <?= $row['Email'] ?></p> -->
									</div>
								</div>						  
							</div>					
						<?php
						}
						unset($result);
						?>
					</div>
					<?php
				}
			} catch (PDOException $e) {
				die("ERROR: Unable to execute $sql. " . $e->getMessage());
			}
			include_once('include/db_close_pdo.php');
			?>
		</div>
	</main> 
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>