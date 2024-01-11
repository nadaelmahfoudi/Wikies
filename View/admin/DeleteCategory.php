<?php
require_once '../../Model/CategorieModel.php';

// Check if the category ID is provided
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Create an instance of CategoryModel
    $categoryModel = new CategorieModel();

    // Call the deleteCategory method to delete the category
    $result = $categoryModel->deleteCategory($categoryId);

    if ($result) {
        // Success, redirect to the categories page or show a success message
        header('Location: Categorie.php');
        exit;
    } else {
        // Handle the error, show an error message or redirect to an error page
        echo 'Error deleting category';
        exit;
    }
} else {
    // Handle the case where the category ID is not provided, show an error message or redirect
    echo 'Category ID not provided';
    exit;
}
?>
