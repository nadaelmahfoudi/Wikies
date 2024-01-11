<?php

class CategoryController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAllCategories()
    {
        $categories = $this->model->getAllCategories();
        // Render view with $categories data
        include('path_to_your_view_file.php');
    }

    public function addCategory($categoryName)
    {
        $result = $this->model->addCategory($categoryName);
        // Handle the result (success or failure)
        // Redirect to the appropriate page
    }

    public function updateCategory($categoryId, $categoryName)
    {
        $result = $this->model->updateCategory($categoryId, $categoryName);
        // Handle the result (success or failure)
        // Redirect to the appropriate page
    }

    public function deleteCategory($categoryId)
    {
        $result = $this->model->deleteCategory($categoryId);
        // Handle the result (success or failure)
        // Redirect to the appropriate page
    }
}
