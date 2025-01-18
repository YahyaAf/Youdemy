<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\Admin;

$database = new Database("youdemy");
$db = $database->getConnection();

if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    $username = $_SESSION['user']['username'];
    $email = $_SESSION['user']['email'];
    $profile_picture_url = $_SESSION['user']['profile_picture_url'];

    $user = new Admin($db);
    

    $users = $user->readAll(); 

    // supression d'un user
    $id = isset($_GET['id']) ? htmlspecialchars(strip_tags($_GET['id'])) : null;
    if ($id) {
      if ($user->deleteUser($id)) {
          header("Location: utilisateur.php");
          exit();
      } else {
          echo "Échec de la suppression de l'utilisateur.";
      }
    }

    // Update the role of a user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'updateRole') {
  $role = $_POST['role'];
  $id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : null;

  if ($user->updateUserRole($id, $role)) {
      header("Location: utilisateur.php");
      exit();
  } else {
      echo "Failed to update role.";
  }
}

// Update the status of a user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'updateStatus') {
  $status = $_POST['status'];
  $id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : null;

  if ($user->updateActivationStatus($id, $status)) {
      header("Location: utilisateur.php");
      exit();
  } else {
      echo "Failed to update status.";
  }
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
          <li>
            <a href="./dashboard.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="./icons.php">
              <i class="now-ui-icons education_atom"></i>
              <p>Icons</p>
            </a>
          </li>
          <li>
            <a href="./map.php">
              <i class="now-ui-icons location_map-big"></i>
              <p>Maps</p>
            </a>
          </li>
          <li class="active ">
            <a href="./notifications.php">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Notifications</p>
            </a>
          </li>
          <li>
            <a href="./user.php">
              <i class="now-ui-icons users_single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li>
            <a href="./tables.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Table List</p>
            </a>
          </li>
          <li>
            <a href="./typography.php">
              <i class="now-ui-icons text_caps-small"></i>
              <p>Typography</p>
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
            <a class="navbar-brand" href="#pablo">Notifications</a>
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
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header">
        <div class="header text-center">
          <h2 class="title">Gestion D'utilisateur</h2>
          <p class="category">Handcrafted by me <a target="_blank" href="">Yahya afadisse</a>. Please checkout the <a href="" target="_blank">full documentation.</a></p>
        </div>
      </div>

      <!-- gestion du utilisateur -->
      <div class="content">
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                          <h5 class="title">Affiche All Users</h5>
                          <p class="category">
                              Handcrafted by our friends from 
                              <a href="">safi</a>
                          </p>
                      </div>
                      <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="text-black">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Activation</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php if (!empty($users)) : ?>
                                    <?php foreach ($users as $u) : ?>
                                        <tr class="border-t border-gray-300 hover:bg-gray-100 transition duration-200">
                                            <td class="px-6 py-4"><?php echo htmlspecialchars($u['username']); ?></td>
                                            <td class="px-6 py-4"><?php echo htmlspecialchars($u['email']); ?></td>
                                            <td class="px-6 py-4">
    <form action="utilisateur.php" method="POST" class="flex items-center space-x-3">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($u['id']); ?>">
        <input type="hidden" name="action" value="updateStatus">

        <select name="status" id="status_<?php echo $u['id']; ?>" class="bg-gray-200 text-gray-700 border border-gray-400 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="pending" <?php echo htmlspecialchars($u['activation']) === 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="accepted" <?php echo htmlspecialchars($u['activation']) === 'accepted' ? 'selected' : ''; ?>>Accepted</option>
            <option value="baned" <?php echo htmlspecialchars($u['activation']) === 'baned' ? 'selected' : ''; ?>>Banned</option>
        </select>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            Save
        </button>
    </form>
</td>
<td class="px-6 py-4">
    <form action="utilisateur.php" method="POST" class="flex items-center space-x-3">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($u['id']); ?>">
        <input type="hidden" name="action" value="updateRole">

        <select name="role" id="role_<?php echo $u['id']; ?>" class="bg-gray-200 text-gray-700 border border-gray-400 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="admin" <?php echo htmlspecialchars($u['role']) === 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="etudiant" <?php echo htmlspecialchars($u['role']) === 'etudiant' ? 'selected' : ''; ?>>Etudiant</option>
            <option value="enseignant" <?php echo htmlspecialchars($u['role']) === 'enseignant' ? 'selected' : ''; ?>>Enseignant</option>
        </select>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            Save
        </button>
    </form>
</td>

                                            <td class="px-6 py-4">
                                              <a href="utilisateur.php?id=<?php echo htmlspecialchars($u['id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir banned cet utilisateur ?');" class="btn btn-danger btn-sm">Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-400 py-4">No users found.</td>
                                    </tr>
                                <?php endif; ?>
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