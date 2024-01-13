<?php
include 'CategoryController.php';

class WikiController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAllWikiEntries()
    {
        $wikie = new WikiModel();
        $wikies = $wikie->getAllWikiEntries();
        return $wikies;
    }

    public function addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId)
    {
        // Process the form data only when the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $dateCreate = date('Y-m-d H:i:s');
            $status = $_POST['status'];
            $description = $_POST['description'];
            $user_id = $_POST['user_id'];
    
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            if ($categoryId === null) {
                echo 'Error: Category is required.';
                exit;
            }
    
            $category = new CategorieModel();
            $categories = $category->getAllCategories();
    
            $wikiModel = new WikiModel();
            $result = $wikiModel->addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId);
    
            if ($result) {
                header('Location: /?page=Wiki');
                exit;
            } else {
                echo 'Error adding wiki entry.';
            }
        }
    }
    

    public function updateWikiEntry($wikiId, $title, $content, $description, $userId, $categoryId)
    {
        $result = $this->model->updateWikiEntry($wikiId, $title, $content, $description, $userId, $categoryId);
    }

    public function deleteWikiEntry($wikiId)
    {
        if (isset($_GET['id'])) {
            $wikiId = $_GET['id'];
        
            $wikiModel = new WikiModel();
            $result = $wikiModel->deleteWikiEntry($wikiId);
        
            if ($result) {
                header('Location: /?page=Wiki');
                exit;
            } else {
                echo 'Error deleting Wiki entry';
                exit;
            }
        } else {
            echo 'Wiki Entry ID not provided';
            exit;
        }
    }

    public function searchWikiByTitle($title) {
        $wikiModel = new WikiModel();
        $results = $wikiModel->searchWikiByTitle($title);
        
    }
}
