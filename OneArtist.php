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
        <title>One Artist</title>

        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">        
        <!-- Custom styles for this template -->
        <link href="navbar-top-fixed.css" rel="stylesheet">
    </head>

    <body>    		    
        <?php
        include_once('include/navbar.php');
        include_once('include/db_connect_pdo.php');
        if (isset($_GET['artistname'])) {
            //Filter to remove tags and encode special characters
            $artistname = filter_var($_GET['artistname'], FILTER_SANITIZE_STRING);
            try {
                $sql = "SELECT * FROM Artist where ArtistName = '$artistname'";
                $result = $pdo->query($sql);
            } catch (PDOException $e) {
                die("ERROR: Could not able to execute $sql. " . $e->getMessage());
            }
        } else {
            exit('Painting does not exist');
        }
        ?>
        <main class="container">
            <div class="bg-light p-3 rounded">
                <h1>Artist</h1> 
                <?php
                if ($result->rowCount() > 0) {
                    echo "<div class=\"row\">";
                    $row = $result->fetch()
                    ?>				
                    <div class="card-columns">
                        <div class="card">		
                            <!-- base64 encoding of image data from database -->
                            <img class="card-img-top" src="data:image/png;base64, <?php echo base64_encode($row['Image']); ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Artist : <?= $row['ArtistName'] ?></h5>
                                <p class="card-text">Life Span : <?= $row['BornYear'] . "-" . $row['DeathYear'] ?></p>
                                <?php
                                $Id = $row['Id'];
                                try {
                                    $sql = "SELECT DISTINCT(ArtStyle) FROM Style RIGHT JOIN Painting ON Style.Id = Painting.ArtStyleID  where ArtistId = $Id";
                                    $result = $pdo->query($sql);
                                    if ($result->rowCount() > 0) {
                                        while ($row = $result->fetch()) {
                                            ?>
                                            <p class="card-text">Style : <?= $row['ArtStyle'] ?></p>
                                            <?php
                                        }
                                        unset($result);
                                    }
                                } catch (PDOException $e) {
                                    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
                                }
                                ?>
                            </div>						  
                        </div>					
                        <?php
                        unset($result);
                        echo "</div>";
                    } else {
                        ?>					
                        <div class="alert alert-warning " role="alert">				  				  
                            Artist name <?php echo $artistname; ?> not found.
                        </div>
                        <?php
                    }
                    include_once('include/db_close_pdo.php');
                    ?>
                </div>
        </main>  
        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>  
    </body>
</html>