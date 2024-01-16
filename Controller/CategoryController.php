<?php

class CategoryController
{


    public function getAllCategories()
    {
        $category = new CategorieModel();
        $categories = $category->getAllCategories();
        return $categories;
    }

    public function addCategory($categoryName)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryName = $_POST['category_name'];
            $categoryModel = new CategorieModel();
            $result = $categoryModel->addCategory($categoryName);
        
            if ($result) {
                header('Location: /?page=Categorie');
                exit;
            } else {
                echo 'Error adding category';
            }
        }
    }

    public function updateCategory($categoryId, $categoryName)
    {

        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];
        
            $categoryModel = new CategorieModel();
            $categories = $categoryModel->updateCategory('categorie', ' id = ' . $categoryId);
        

        
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categoryName = $_POST['category_name'];
                $result = $categoryModel->updateCategory($categoryId, $categoryName);
        
                if ($result) {
                    header('Location: /?page=Categorie');
                    exit;
                } else {
                    var_dump($_POST);
                    echo 'Error updating category';
                }
            }
        } else {
            echo 'Category ID not provided';
            exit;
        }
    }

    public function deleteCategory($categoryId)
    {
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];
            $categoryModel = new CategorieModel();
            $result = $categoryModel->deleteCategory($categoryId);
        
            if ($result) {
                header('Location: /?page=Categorie');
                exit;
            } else {
                echo 'Error deleting category';
                exit;
            }
        } else {
            echo 'Category ID not provided';
            exit;
        }
    }
}
