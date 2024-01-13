<?php
// router.php


class Router {
    public function route() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'index';

        switch ($page) {
            case 'Categorie':
                $this->handleCategories();
                break;
            case 'Wiki':
                $this->handleWikies();
                break;
            case 'Tag':
                $this->handleTags();
                break;
            default:
                $this->handleHome();
        }
    }

    private function handleHome() {
        header("Location: View/index.php");
    }

    private function handleCategories() {
        require_once 'Model/CategorieModel.php'; 
        require_once 'Controller/CategoryController.php'; 

        $categoryModel = new CategorieModel();
        $categoryController = new CategoryController($categoryModel);

        $action = isset($_GET['action']) ? $_GET['action'] : 'getAllCategories';

        switch ($action) {
            case 'getAllCategories':
                $categories = $categoryController->getAllCategories();
                include 'View/admin/Categorie.php';
                break;
            case 'addCategory':
                $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : '';
                $categoryController->addCategory($categoryName);
                include 'View/admin/AddCategory.php';
                break;
            case 'updateCategory':
                $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';
                $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : '';
                $categoryController->updateCategory($categoryId, $categoryName);
                include 'View/admin/EditCategory.php';
                break;
            case 'deleteCategory':
                $categoryId = isset($_GET['id']) ? $_GET['id'] : '';
                $categoryController->deleteCategory($categoryId);
                break;
            default:
                $categoryController->getAllCategories();
        }
    }

    private function handleWikies() {
        require_once 'Model/WikiModel.php'; 
        require_once 'Controller/WikiController.php'; 
        require_once 'Model/CategorieModel.php';  // Add this line
        require_once 'Controller/CategoryController.php';  // Add this line
    
        $categoryModel = new CategorieModel();  // Add this line
        $categoryController = new CategoryController($categoryModel);  // Add this line
        $categories = $categoryController->getAllCategories();  // Add this line
    
        $wikiModel = new WikiModel();
        $wikiController = new WikiController($wikiModel);
    
        $action = isset($_GET['action']) ? $_GET['action'] : 'getAllWikiEntries';
    
        switch ($action) {
            case 'getAllWikiEntries':
                $wikies = $wikiController->getAllWikiEntries();
                include 'View/Wiki.php';
                break;
            case 'addWikiEntry':
                $title = isset($_POST['title']) ? $_POST['title'] : '';
                $content = isset($_POST['content']) ? $_POST['content'] : '';
                $dateCreate = isset($_POST['datecreate']) ? $_POST['datecreate'] : '';
                $status = isset($_POST['status']) ? $_POST['status'] : '';
                $description = isset($_POST['description']) ? $_POST['description'] : '';
                $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
                $categoryId = isset($_POST['category_id']) ? $_POST['category_id'] : '';
                $categories = $categoryController->getAllCategories();  // Add this line
                $wikiController->addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId);
                // Pass $categories to the method
                include 'View/AddWiki.php';
                break;
                case 'deleteWikiEntry':
                    $wikiId = isset($_GET['id']) ? $_GET['id'] : '';
                    $wikiController->deleteWikiEntry($wikiId);
                    break;
                default:
                $wikiController->getAllWikiEntries();
        }
    }

    private function handleTags() {
        require_once 'Model/TagModel.php'; 
        require_once 'Controller/TagController.php';  
    
        $tagModel = new TagModel();  
        $tagController = new TagController($tagModel);  
    
        $action = isset($_GET['action']) ? $_GET['action'] : 'getAllTags';
    
        switch ($action) {
            case 'getAllTags':
                $tags = $tagController->getAllTags();  
                include 'View/admin/Tag.php';  
                break;
            case 'addTag':
                $tagName = isset($_POST['tagName']) ? $_POST['tagName'] : '';  
                $tagController->addTag($tagName);  
                include 'View/admin/AddTag.php';  
                break;
            case 'updateTag':
                $tagId = isset($_POST['tagId']) ? $_POST['tagId'] : '';  
                $tagName = isset($_POST['tagName']) ? $_POST['tagName'] : '';  
                $tagController->updateTag($tagId, $tagName);  
                include 'View/admin/EditTag.php';  
                break;
            case 'deleteTag':
                $tagId = isset($_GET['id']) ? $_GET['id'] : '';  
                $tagController->deleteTag($tagId);  
                break;
            default:
                $tagController->getAllTags();  
        }
    }
    
    
}

?>
