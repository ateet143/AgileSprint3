<?php
// Team      : ALE (Atit, Ellena, Low)
// Date      : Oct 2022
?>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Low Kok Wei">        
	<title>Member</title>

	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">       
	<!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
</head>

<body>    	
<?php
	include_once('include/navbar.php');
	include_once('include/db_connect_acme_pdo.php');	
?>	
  
	<main class="container">
	  <div class="bg-light p-3 rounded">
		<h1>Member</h1>				
			<!-- Avoid PHP_SELF exploit -->
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="d-flex" role="search" method="post">
                <input class="form-control ms-2 me-2" type="search" placeholder="Member Email Search" aria-label="Search" name="Email">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
									
<?php		
			//Processing member after self-call is submitted
			if (isset($_POST['Email'])) {
				if(!empty($_POST['Email'])) {
					// Remove any illegal character from the data
					$email = filter_var($_POST['Email'],FILTER_SANITIZE_STRING);
					
					try {
						$sql = "SELECT * FROM Member WHERE Email = '$email'";          
						$result = $pdo->query($sql);			
						if ($result->rowCount()>0){								
							$row = $result->fetch();
?>						
							<table class="table table-bordered table-striped mt-2 ms-2">
                                    <thead>
                                        <tr>                                        
                                            <th>Id</th>
                                            <th>First Name</th>                                        
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Monthly Newsletter</th>
											<th>Breaking News</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
										<tr>
                                            <td><?= $row['Id'] ?></td>
                                            <td><?= $row['FirstName'] ?></td>
                                            <td><?= $row['LastName'] ?></td>
                                            <td><?= $row['Email'] ?></td>
											<td><?= $row['MonthlyNewsletter'] ?></td>
											<td><?= $row['BreakingNews'] ?></td>
                                            <td>                                                                       
                                               <!-- Button to delete this member -->
                                                <a href="DeleteMember.php?&Email=<?= $row['Email'] ?>" class="btn btn-secondary">Delete</a>
                                            </td>
                                        </tr>			
                                        
                                    </tbody>                        
							</table>
<?php                                        
                            unset($result);                            
						}
						else{			
							echo "<p class=mt-2>Member Email address not found ! </p>";						
						}
						
					} catch(PDOException $e) {
						die("ERROR: Could not able to execute $sql. " . $e->getMessage());
					}
				}
			}
			include_once('include/db_close_pdo.php');		  					
?>
		<div class="btn-group mt-2 ms-2" role="group" aria-label="Basic outlined">		  
		  <a href="#" class="btn btn-outline-primary">All</a>
		  <a href="#" class="btn btn-outline-primary">Monthly Newsletter</a>
		  <a href="#" class="btn btn-outline-primary">Breaking News</a>
		</div>
	</div>
	</main>  
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>