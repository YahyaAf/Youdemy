<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\categories\Category;
    use Src\tags\Tag;
    use Src\courses\Cours;

    $database = new Database("youdemy");
    $db = $database->getConnection();

    // categorie
    $category = new Category($db);
    $categories = $category->read();

    // tags
    $tag = new Tag($db);
    $tags = $tag->read();

    $cours = new Cours($db);
    if (isset($_GET['id'])) {
        $cours_id = $_GET['id'];
        $cours_data = $cours->read($cours_id);
    
        if ($cours_data) {
            $current_title = $cours_data['title'];
            $current_description = $cours_data['description'];
            $current_contenu = $cours_data['contenu'];
            $current_featured_image = $cours_data['featured_image'];
            $current_category_id = $cours_data['category_id'];
            $current_scheduled_date = $cours_data['scheduled_date_only'];
            $current_video = $cours_data['contenu_video'];
            $current_document = $cours_data['contenu_document'];
            
        } else {
            echo "Cours not found!";
            exit();
        }
    } else {
        echo "Cours ID is missing!";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<title>Update cours</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-800 via-gray-900 to-black min-h-screen flex items-center justify-center ">
    <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-6 rounded-lg shadow-lg w-full sm:w-11/12 md:w-8/12 lg:w-6/12 xl:w-5/12 mt-8 mb-5">
        <h1 class="text-center text-3xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
            Modifier Course
        </h1>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium mb-2">Course Title</label>
                <input
                    value="<?php echo htmlspecialchars($current_title); ?>" 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter course title" 
                    required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium mb-2">Course Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter course description" 
                    required><?php echo htmlspecialchars($current_description); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="contenu" class="block text-lg font-medium mb-2">Course Content Type</label>
                <select 
                    
                    id="contenu" 
                    name="contenu" 
                    class="w-full mt-1 p-2.5 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                    required
                >
                    <option value="">--Please choose content type--</option>
                    <option value="video" <?php echo ($current_contenu == 'video') ? 'selected' : ''; ?>>Video</option>
                    <option value="document" <?php echo ($current_contenu == 'document') ? 'selected' : ''; ?>>Document</option>
                </select>
            </div>
            <div id="video" class="mb-4">
                <label for="contenu_video" class="block text-lg font-medium mb-2">Video URL</label>
                <input 
                    value="<?php echo htmlspecialchars($current_video); ?>"
                    type="url" 
                    id="contenu_video" 
                    name="contenu_video" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter video URL" 
                    >
            </div>
            <div id="document" class="mb-4">
                <label for="contenu_document" class="block text-lg font-medium mb-2">Course Document</label>
                <textarea 
                    id="contenu_document" 
                    name="contenu_document" 
                    rows="4" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter course document content" 
                    ><?php echo htmlspecialchars($current_document); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="categorie" class="block text-lg font-medium mb-2">Category</label>
                <select 
                    id="categorie" 
                    name="categorie" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">-- Please choose a category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo ($current_category_id == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="tags" class="block text-lg font-medium mb-2">Tags</label>
                <select 
                    id="tags" 
                    name="tags[]" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    multiple>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?php echo htmlspecialchars($tag['id']); ?>">
                            <?php echo htmlspecialchars($tag['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-sm text-gray-400 mt-2">Hold down the Ctrl (Windows) or Command (Mac) key to select multiple tags.</p>
            </div>
            <div class="mb-4">
                <label for="featured_image" class="block text-lg font-medium mb-2">Featured Image URL</label>
                <input
                    value="<?php echo htmlspecialchars($current_featured_image); ?>"
                    type="url" 
                    id="featured_image" 
                    name="featured_image" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter image URL" 
                    required>
            </div>
            <div class="mb-4">
                <label for="scheduled_date" class="block text-lg font-medium mb-2">Scheduled Date</label>
                <input
                    value="<?php echo htmlspecialchars($current_scheduled_date); ?>"
                    type="date" 
                    id="scheduled_date" 
                    name="scheduled_date" 
                    class="w-full p-2.5 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>
            <button 
                type="submit" 
                class="w-full bg-yellow-500 hover:bg-yellow-600 py-3 rounded-lg text-lg font-semibold transition duration-300">
                Update Course
            </button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectContenu = document.getElementById('contenu');
            const contenuVideo = document.getElementById('video');
            const contenuDocument = document.getElementById('document');

            toggleFields(selectContenu.value);

            selectContenu.addEventListener('change', function () {
                toggleFields(this.value);
            });

            function toggleFields(value) {
                if (value === 'video') {
                    contenuVideo.style.display = 'block';
                    contenuVideo.setAttribute('required', 'required');
                    contenuDocument.style.display = 'none';
                    contenuDocument.removeAttribute('required');
                } else if (value === 'document') {
                    contenuVideo.style.display = 'none';
                    contenuVideo.removeAttribute('required');
                    contenuDocument.style.display = 'block';
                    contenuDocument.setAttribute('required', 'required');
                } else {
                    contenuVideo.style.display = 'none';
                    contenuVideo.removeAttribute('required');
                    contenuDocument.style.display = 'none';
                    contenuDocument.removeAttribute('required');
                }
            }
        });
    </script>
</body>

</html>