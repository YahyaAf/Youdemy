<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\categories\Category;
    use Src\tags\Tag;
    use Src\courses\Cours;

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
      header('Location: ../front_office/erreur404.php');
      exit();
    }

    $database = new Database("youdemy");
    $db = $database->getConnection();

    // categorie
    $category = new Category($db);
    $categories = $category->read();

    // tags
    $tag = new Tag($db);
    $tags = $tag->read();

    $coursObj = new Cours($db);


    // Update the role of a cours document
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'updateRoleDocument') {
      $status = $_POST['status'];
      $id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : null;

      if ($coursObj->updateStatusCours($id, $status)) {
          header("Location: publication.php");
          exit();
      } else {
          echo "Failed to update role.";
      }
    }

    // Update the status of a cours video 
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'updateRoleVideo') {
      $status = $_POST['status'];
      $id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : null;

      if ($coursObj->updateStatusCours($id, $status)) {
          header("Location: publication.php");
          exit();
      } else {
          echo "Failed to update status.";
      }
    }
    
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
            <a class="navbar-brand" href="#pablo">Cours List</a>
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
                <h5 class="title">Affiche All Courses</h5>
                  <p class="category">
                    Handcrafted by our friends from 
                    <a href="">safi</a>
                  </p>
            </div>
            <h2 class=" font-bold mb-6 text-center text-gradient-to-r from-blue-400 to-purple-500 mt-5">
                    Courses List (Document Type)
            </h2>
            <div class="card-body">
              <table class="w-full text-sm text-left text-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Course Title</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Tags</th>
                            <th class="px-4 py-2">Content</th>
                            <th class="px-4 py-2">Scheduled Date</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $documentCourses = $coursObj->readAll();
                        foreach ($documentCourses as $course): ?>
                            <tr class="border-t border-gray-700">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['title']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['category_name']); ?></td>
                                <td class="px-4 py-2">
                                    <?php 
                                        $tags = explode(',', $course['tags']);
                                        foreach ($tags as $tag) {
                                            echo "<span class='bg-primary text-black rounded-pill px-2 py-1 small'>" . htmlspecialchars($tag) . "</span> ";
                                        }
                                    ?>
                                </td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['contenu']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['scheduled_date_only']); ?></td>
                                <td class="px-6 py-4">
                                  <form action="" method="POST" class="flex items-center space-x-3">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                    <input type="hidden" name="action" value="updateRoleDocument">
                                    <select name="status" id="status_<?php echo $course['id']; ?>" class="bg-gray-200 text-gray-700 border border-gray-400 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="draft" <?php echo htmlspecialchars($course['status']) === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo htmlspecialchars($course['status']) === 'published' ? 'selected' : ''; ?>>Published</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Save
                                    </button>
                                  </form>
                                </td>                          
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Table for Video Courses -->
                <h2 class=" font-bold mb-6 text-center text-gradient-to-r from-blue-400 to-purple-500 mt-5">
                    Courses List (Video Type)
                </h2>
                <table class="w-full text-sm text-left text-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Course Title</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Tags</th>
                            <th class="px-4 py-2">Content</th>
                            <th class="px-4 py-2">Scheduled Date</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $videoCourses = $coursObj->readAll("video");
                        foreach ($videoCourses as $course): ?>
                            <tr class="border-t border-gray-700">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['title']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['category_name']); ?></td>
                                <td class="px-4 py-2">
                                    <?php 
                                        $tags = explode(',', $course['tags']);
                                        foreach ($tags as $tag) {
                                            echo "<span class='bg-primary text-black rounded-pill px-2 py-1 small'>" . htmlspecialchars($tag) . "</span> ";
                                        }
                                    ?>
                                </td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['contenu']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($course['scheduled_date_only']); ?></td>
                                <td class="px-6 py-4">
                                  <form action="" method="POST" class="flex items-center space-x-3">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                    <input type="hidden" name="action" value="updateRoleVideo">
                                    <select name="status" id="status_<?php echo $course['id']; ?>" class="bg-gray-200 text-gray-700 border border-gray-400 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="draft" <?php echo htmlspecialchars($course['status']) === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo htmlspecialchars($course['status']) === 'published' ? 'selected' : ''; ?>>Published</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Save
                                    </button>
                                  </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
              </div>
            </div>
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
</body>

</html>