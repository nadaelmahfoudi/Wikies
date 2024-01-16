<?php
require_once 'CategoryController.php';
require_once 'Controller/TagController.php';
require_once 'Model/TagModel.php';

class WikiController
{
    private $model;

    
    public function getAllWikiEntries()
    { 
        $wikie = new WikiModel();
        $wikies = $wikie->getAllWikiEntries();
        return $wikies;
    }
    public function getAuthorWiki($id){
        $wikie = new WikiModel();
        $wikies = $wikie->getAuthorWiki($id);
        return $wikies;
    }


    public function getAcceptedWikies()
    { 
        $wikie = new WikiModel();
        $wikies = $wikie->getAcceptedWikies();
        return $wikies;
    }

    public function addWikiEntry($title, $content, $dateCreate, $status, $description, $categoryId)
    {
        // Process the form data only when the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $dateCreate = date('Y-m-d H:i:s');
            $status = $_POST['status'];
            $description = $_POST['description'];
    
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            if ($categoryId === null) {
                echo 'Error: Category is required.';
                exit;
            }
    
            // Handle tags
            $tagsInput = isset($_POST['tags']) ? $_POST['tags'] : '';
            if (!is_array($tagsInput)) {
                $tagsArray = explode(',', $tagsInput);
            } else {
                $tagsArray = $tagsInput;
            }
    
            //Add tags if not already added
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
    
            $userId = 2;
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
        $wikiId = intval($wikiId);
    

        $wikiModel = new WikiModel();
        $result = $wikiModel->updateWikiStatus($wikiId, $newStatus);

        if ($result) {
            header('Location: /?page=Wiki');
            exit;
        } else {
            echo 'Error adding wiki entry.';
        }
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

    public function editWikiEntry() {
        $wikiModel = new WikiModel(); // Create an instance of WikiModel
        $categories = $wikiModel->getAllCategories();
        
        if (isset($_GET['id'])) {
            $wikiId = $_GET['id'];
            $wikiEntry = $wikiModel->selectRecords('wiki', 'id = ' . $wikiId);

            if (empty($wikiEntry)) {
                echo 'Wiki entry not found';
                exit;
            }

            $wikiEntry = $wikiEntry[0];

            // Assuming you have a method to get tags for this entry
            $tags = $wikiModel->getTagsForWikiEntry($wikiId);
            $selectedTags = array_column($tags, 'tag_id');
        } else {
            echo 'Wiki ID not provided';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process the form submission
            $title = $_POST['title'];
            $content = $_POST['content'];
            $dateCreate = $_POST['datecreate'];
            $status = $_POST['status'];
            $description = $_POST['description'];
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

            // Update the Wiki entry
            $result = $wikiModel->updateWikiEntry($wikiId, $title, $content, $dateCreate, $status, $description, $categoryId, $tags);

            if ($result) {
                header('Location: Wiki.php');
                exit;
            } else {
                echo 'Error updating wiki entry.';
            }
        }

        require_once 'EditWiki.php';
    }

    public function getUserWikies()
    {
        $loggedInUserId = $_SESSION['idUser']; 
        $userModel = new UserModel();
        $wikie = new WikiModel();
        $wikies = $userModel->getWikiesByUserId($loggedInUserId);
    
        return $wikies;
    }




    // public function getAllWikiEntriesWithTags()
    // {
    //     $wikie = new WikiModel();
    //     $wikies = $wikie->getAllWikiEntries();
    
    //     // Fetch tags for each wiki entry
    //     $tagModel = new TagModel();
    //     foreach ($wikies as &$wikie) {
    //         $tags = $tagModel->getWikiTags($wikie['id']); // Assuming getTagsForWikiEntry is a method in your TagModel
    //         $wikie['tags'] = $tags;
    //     }
    
    //     return $wikies;
    // }


// public function getWikiDetails($wikiId) {
//     $wikiModel = new WikiModel();
//     $result = $wikiModel->getWikiDetails($wikiId);
    
//     // Fetch tags for the wiki entry using TagModel directly
//     $tagModel = new TagModel();
//     $result['tags'] = $tagModel->getWikiTags($wikiId);

//     if ($result && !empty($result)) {
//         // Pass the $result to the view
//         include 'View/single_pageWiki.php';
//     } else {
//         echo 'Error';
//     }
// }

    
    


    public function searchWikiByTitle($input) {

        
    $wikiModel = new WikiModel();
    return $wikiModel->searchWikiByTitle($input);
              
    }
    
}
