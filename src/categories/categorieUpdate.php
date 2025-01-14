<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\categories\Category;

$database = new Database("youdemy");
$db = $database->getConnection();

$category = new Category($db);

// Fetch category by id for update
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $category->id = $category_id;
    $category_data = $category->readOne(); 
    if ($category_data) {
        $current_name = $category_data['name'];
    } else {
        echo "Category not found!";
        exit();
    }
}

// Update category data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $category_name = htmlspecialchars(strip_tags($_POST['name']));

    $category->name = $category_name;
    if ($category->update()) {
        header("Location: ../../public/back_office/categorie.php");
        exit();
    } else {
        echo "Failed to update category.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="../../public/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../public/assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../public/assets/demo/demo.css" rel="stylesheet" />
    <title>Update Category</title>
    <style>
        body {
            background-color: orange;
            height: 100vh;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: #343a40;
            border-radius: 8px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="form-container">
        <h1 class="text-center text-white mb-4">Modifier Categorie</h1>
        <form action="../../src/categories/categorieUpdate.php?id=<?= $category_id; ?>" method="POST">
            <div class="form-group">
                <label for="name" class="text-white">Tag Name</label>
                <input value="<?= isset($current_name) ? htmlspecialchars($current_name) : ''; ?>" type="text" class="form-control text-yellow" id="name" name="name" placeholder="Entrer votre tag name" required>

            </div>
            <button type="submit" class="btn btn-warning btn-block">Modifier Categorie</button>
        </form>
    </div>
</body>
</html>
