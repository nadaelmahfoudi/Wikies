<?php

class TagController
{
    public function getAllTags()
    {
        $tagModel = new TagModel();
        $tags = $tagModel->getAllTags();
        return $tags;
    }

    public function addTag($tagName)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tagName = $_POST['tag_name'];
            $tagModel = new TagModel();
            $result = $tagModel->addTag($tagName);

            if ($result) {
                header('Location: /?page=Tag');
                exit;
            } else {
                echo 'Error adding tag';
            }
        }
    }

    public function updateTag($tagId, $tagName)
    {
        if (isset($_GET['id'])) {
            $tagId = $_GET['id'];

            $tagModel = new TagModel();


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tagName = $_POST['tag_name'];
                $result = $tagModel->updateTag($tagId, $tagName);

                if ($result) {
                    header('Location: /?page=Tag');
                    exit;
                } else {
                    var_dump($_POST);
                    echo 'Error updating tag';
                }
            }
        } else {
            echo 'Tag ID not provided';
            exit;
        }
    }

    public function deleteTag($tagId)
    {
        
            $tagModel = new TagModel();
            $result = $tagModel->deleteTag($tagId);
        
            if ($result) {
                header('Location: /?page=Tag');
                exit;
            } else {
                echo 'Error deleting tag';
                exit;
            }
      
    }
}
