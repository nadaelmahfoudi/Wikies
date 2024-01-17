<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar " >
        <div class="position-sticky">
          <ul class="nav flex-column">
            
              
            <?php 
                    if (session_status() == PHP_SESSION_NONE)session_start();
                    if (isset($_SESSION['roleUser']) && $_SESSION['roleUser'] == 'admin'):
              ?>
            <li class="nav-item">
              <a class="nav-link active" href="/index.php?page=Statistic">
                Statistiques
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/index.php?page=Categorie">
                Categories
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/index.php?page=Tag">
                Tags
              </a>
            </li>
            <?php endif;?>
            <li class="nav-item">
              <a class="nav-link" href="/index.php?page=Wiki">
                Wikies
              </a>
            </li>

          </ul>
        </div>
      </nav>