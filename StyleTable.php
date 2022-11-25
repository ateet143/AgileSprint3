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
        <title>Style Table</title>

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
                            <h2 class="float-start">All Styles</h2>
                            <!-- Button to add new Style -->
                            <a href="CreateStyle.php" class="btn btn-success float-end">Add New Style</a>
                        </div>
<?php
                        try {
                            $sql = "SELECT * FROM Style ORDER BY Id";
                            $result = $pdo->query($sql);
                            if ($result->rowCount() > 0) {
                                // Fill the table with rows of Style record
?>						
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Style</th>                                        
                                            <th>Record</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php 										while ($row = $result->fetch()) { ?>
                                            <tr>
                                                <td><?= $row['Id'] ?></td>
                                                <td><?= $row['ArtStyle'] ?></td>
                                                <td>                        
                                                    <!-- Button to update this style -->
                                                    <a href="UpdateStyle.php?&artstyle=<?= $row['ArtStyle'] ?>" class="btn btn-secondary">Update</a>
                                                    <!-- Button to delete this style -->
                                                    <a href="DeleteStyle.php?&artstyle=<?= $row['ArtStyle'] ?>" class="btn btn-secondary">Delete</a>
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
                        } catch (PDOException $e) {
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