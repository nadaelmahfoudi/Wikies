<nav class="navbar navbar-expand-lg" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                <div class="container">
                    <a class="navbar-brand" href="index.html">
                        <img src="images/logo.png" alt="logo" style="width: 30px">
                        <span>Wiki</span>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                        <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                    </div>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php">Home</a>
                            </li>
                            <?php 
                            session_start();
                            if (isset($_SESSION['roleUser']) && $_SESSION['roleUser'] == 'admin'):
                            ?>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="Dashboard.php">Dashboard</a>
                            </li>

                            <?php endif;?>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_4">FAQs</a>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>

                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="topics-listing.php">Topics Listing</a></li>

                                    <li><a class="dropdown-item" href="contact.php">Contact Form</a></li>
                                </ul>
                            </li>
                        </ul>
                        <?php
                            if (!isset($_SESSION['nameUser'])):
                        ?>
                        <div class="d-flex align-items-center">
                            <button data-mdb-ripple-init type="button" class="btn btn-link px-3 me-2">
                              <a href="login.php">Login</a>
                            </button>
                            <button data-mdb-ripple-init type="button" class="btn btn-primary me-3">
                              <a href="sign-up.php">Sign up for free</a>
                            </button>                 
                          </div>
                        <?php else: ?>
                        <p class="dark:text-white" >Welcome ! <?php echo $_SESSION['nameUser']; ?></p>
                        <a href="logout.php" data-mdb-ripple-init type="button" class="btn btn-link px-3 me-2">
                                <span>
                                    Log out 
                                </span>
                                </a>
                        <?php endif; ?>
   
                        <!-- <div class="d-none d-lg-block">
                            <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                        </div> -->
                    </div>
                </div>
            </nav>