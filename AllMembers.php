<?php
// Team      : ALE (Atit, Ellena, Low)
// Developer : Ellena Begg
// Date      : Nov 2022
// Desc		 : Show all members subscribed to our newsletters
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="List all Subscribers to our Newsletters">
        <meta name="author" content="Ellena Begg">    
        <title>All Subscribers</title>

        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
        <!-- Custom styles for this template -->
        <link href="navbar-top-fixed.css" rel="stylesheet">
    </head>

    <body>    		    
        <?php
        include_once('include/navbar.php');
        include('include/db_connect_pdo.php');
        ?>
		<?php
		function checkBoolean($bool)
		{
			if ($bool == true)
			{
				echo "Yes";
			}
			else 
			{
				echo "No";
			}
		}
		?>
        <main class="container">
            <div class="bg-light p-3 rounded">
                <h1>All Members</h1> 
                <?php
                try {
                    $sql = "SELECT * FROM Member ORDER BY LastName";
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
											<p></p>
											<p class="card-text"><b>Subscriptions</b></p>
                                            <p class="card-text">Monthly Newsletter : <?= checkBoolean($row['MonthlyNewsletter']) ?></p>
											<p class="card-text">Breaking News : <?= checkBoolean($row['BreakingNews']) ?></p>
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