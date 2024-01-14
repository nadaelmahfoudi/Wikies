<?php
include 'CategoryController.php';
require_once 'Controller/TagController.php';
include 'Model/TagModel.php';

class WikiController
{
    private $model;

    
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
    
            // Handle tags
            $tagsInput = isset($_POST['tags']) ? $_POST['tags'] : '';
            $tagsArray = explode(',', $tagsInput);
    
            // Add tags if not already added
            $tagModel = new TagModel();
            foreach ($tagsArray as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    // Check if the tag already exists
                    $existingTag = $tagModel->findTagByName($tagName);
    
                    if (!$existingTag) {
                        // Tag doesn't exist, add it
                        $tagModel->addTag($tagName);
                    }
                }
            }
    
            $wikiModel = new WikiModel();
            $result = $wikiModel->addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId, $tagsArray);
    
            if ($result) {
                header('Location: /?page=Wiki');
                exit;
            } else {
                echo 'Error adding wiki entry.';
            }
        }
    }
    

    public function updateWikiStatus($wikiId, $newStatus) {
        // Assurez-vous que $wikiId est un entier
        $wikiId = intval($wikiId);
    
        // Assurez-vous que $newStatus est soit 0, soit 1
        if ($newStatus !== '0' && $newStatus !== '1') {
            return; // Statut non valide
        }
        $wikiModel = new WikiModel();
        $result = $wikiModel->updateWikiStatus($wikiId, $newStatus);

        if ($result) {
            header('Location: /?page=Wiki');
            exit;
        } else {
            echo 'Error adding wiki entry.';
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

    public function getAllWikiEntriesWithTags()
    {
        $wikie = new WikiModel();
        $wikies = $wikie->getAllWikiEntries();
    
        // Fetch tags for each wiki entry
        $tagModel = new TagModel();
        foreach ($wikies as &$wikie) {
            $tags = $tagModel->getWikiTags($wikie['id']); // Assuming getTagsForWikiEntry is a method in your TagModel
            $wikie['tags'] = $tags;
        }
    
        return $wikies;
    }


public function getWikiDetails($wikiId) {
    $wikiModel = new WikiModel();
    $result = $wikiModel->getWikiDetails($wikiId);
    
    // Fetch tags for the wiki entry using TagModel directly
    $tagModel = new TagModel();
    $result['tags'] = $tagModel->getWikiTags($wikiId);

    if ($result && !empty($result)) {
        // Pass the $result to the view
        include 'View/single_pageWiki.php';
    } else {
        echo 'Error';
    }
}

    
    


    public function searchWikiByTitle($title) {
        $wikiModel = new WikiModel();
        $results = $wikiModel->searchWikiByTitle($title);
    
        // Maintenant, vous pouvez passer les résultats à votre vue
        // et afficher les résultats dans la vue.
        include 'View/index.php';
    }
    
}
