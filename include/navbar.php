<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Acme Arts</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="about.php">About</a>
                </li>
                <!-- EDIT nav bar to seperate Paintings and Artists and searches for each. Ellena Begg -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Artists</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="AllArtists.php">All Artists</a></li>
                        <li><a class="dropdown-item" href="#.php">By Style</a></li>
                        <li><a class="dropdown-item" href="ArtistByMedia.php">By Media</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Paintings</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="index.php">All Paintings</a></li>
						<li><a class="dropdown-item" href="Artist.php">By Artist</a></li>
                        <li><a class="dropdown-item" href="Style.php">By Style</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Inventory</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="ArtistTable.php">Artist</a></li>
                        <li><a class="dropdown-item" href="StyleTable.php">Style</a></li>
                        <li><a class="dropdown-item" href="MediaTable.php">Media</a></li>
                        <li><a class="dropdown-item" href="PaintingTable.php">Painting</a></li>
						<li><a class="dropdown-item" href="Login.php">Member</a></li>
                    </ul>
                </li>				
                <li class="nav-item">
                    <a class="nav-link" href="Contact.php">Contact</a>
                </li>
            </ul>
			<!-- Search box to find an Artist by Name -->
            <form action="OneArtist.php" class="d-flex" role="search">
                <input class="form-control ms-2 me-2" type="search" placeholder="Artist Name Search" aria-label="Search" name="artistname">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
			<!-- Search box to find a Paiting by Title -->
            <form action="Painting.php" class="d-flex" role="search">
                <input class="form-control ms-2 me-2" type="search" placeholder="Paiting Title Search" aria-label="Search" name="title">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>			
