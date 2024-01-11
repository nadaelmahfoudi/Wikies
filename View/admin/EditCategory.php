<?php
require_once '../../Model/CategorieModel.php';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    $categoryModel = new CategorieModel();

    // Fetch the category details by ID
    $categories = $categoryModel->selectRecords('categorie', 'id = ' . $categoryId);

    if (empty($categories)) {
        echo 'Category not found';
        exit;
    }

    $category = $categories[0];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming you have a form input named 'category_name'
        $categoryName = $_POST['category_name'];

        // Call the updateCategory method to update the category
        $result = $categoryModel->updateCategory($categoryId, $categoryName);

        if ($result) {
            // Success, redirect to the categories page or show a success message
            header('Location: Categorie.php');
            exit;
        } else {
            // Handle the error, show an error message or redirect to an error page
            echo 'Error updating category';
        }
    }
} else {
    // Handle the case where the category ID is not provided, show an error message or redirect
    echo 'Category ID not provided';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIKI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require_once '../include/nav.php' ?>

<div class="container-fluid">
    <div class="row">
        <!-- Your existing code for the sidebar and main content goes here -->

        <!-- Edit Category Form -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>Edit Category</h2>

            <form method="POST" >
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?= isset($category['category_name']) ? $category['category_name'] : '' ?>" required>
                    <input type="hidden" name="category_id" value="<?= $categoryId ?>">
                </div>
                <button type="submit" value="submit" class="btn btn-primary">Update Category</button>
            </form>
        </main>
        <!-- End Edit Category Form -->

        <!-- Your existing code for the footer goes here -->
    </div>
</div>
</body>
</html>
