<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\categories\Category;
    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
      header('Location: ../front_office/erreur404.php');
      exit();
    }elseif (!isset($_SESSION['user']) || $_SESSION['user']['activation'] === 'baned') {
      header('Location: ../front_office/banned.php');
      exit();
    }

    $database = new Database("youdemy");
    $db = $database->getConnection();

    $category = new Category($db);
    

    $categories = $category->read();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Now UI Dashboard by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="" class="simple-text logo-mini">
          CT
        </a>
        <a href="" class="simple-text logo-normal">
          Heisenberg Tim
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class=" ">
            <a href="./dashboard.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="./tag.php">
              <i class="now-ui-icons education_atom"></i>
              <p>Tags</p>
            </a>
          </li>
          <li>
            <a href="./categorie.php">
              <i class="now-ui-icons location_map-big"></i>
              <p>Categories</p>
            </a>
          </li>
          <li>
            <a href="./utilisateur.php">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Utilisateurs</p>
            </a>
          </li>
          <li>
            <a href="./publication.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Publications</p>
            </a>
          </li>
          <li class="active-pro">
            <a href="./upgrade.php">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Upgrade to PRO</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Maps</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="profile.php">Account</a>
                  <a class="dropdown-item" href="../../src/users/logoutHandler.php">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                          <h5 class="title">Ajouter nouvelle Categories</h5>
                          <p class="category">
                              Handcrafted by our friends from 
                              <a href="">safi</a>
                          </p>
                      </div>
                      <div class="card-body">
                          <form action="../../src/categories/categorieHandler.php" method="POST" class="mt-3">
                              <div class="mb-3">
                                  <label for="name" class="form-label">Categorie Name</label>
                                  <input type="text" class="form-control" id="name" name="name" placeholder="entrer votre categorie name" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Create Categorie</button>
                          </form>      
                      </div>
                  </div>
                  <div class="card-header">
                    <h5 class="title">List de Categories :</h5>
                          <p class="category">
                              Handcrafted by our friends from 
                              <a href="">safi</a>
                          </p>
                  </div>
                  <table class="table table-bordered">
                      <thead class="bg-light">
                          <tr>
                              <th>Name</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          if ($categories) {
                              foreach ($categories as $categorie) {
                                  echo "<tr>
                                          <td style='width: 50%;'>{$categorie['name']}</td>
                                          <td style='width: 50%;'>
                                              <a href='../../src/categories/categorieUpdate.php?id={$categorie['id']}' class='btn btn-warning btn-sm'>Update</a>
                                              <a href='../../src/categories/categorieHandler.php?id={$categorie['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                          </td>
                                      </tr>";
                              }
                          } else {
                              echo "<tr><td colspan='2' class='text-center'>No categories found.</td></tr>";
                          }
                          ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initGoogleMaps();
    });
  </script>
</body>

</html>