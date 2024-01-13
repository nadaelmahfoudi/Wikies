<?php
require_once '../Model/WikiModel.php';

if (isset($_GET['id'])) {
    $wikiId = $_GET['id'];

    $wikiModel = new WikiModel();

    $result = $wikiModel->deleteWikiEntry($wikiId);

    if ($result) {
        header('Location: Wiki.php');
        exit;
    } else {
        echo 'Error deleting Wiki entry';
        exit;
    }
} else {
    echo 'Wiki Entry ID not provided';
    exit;
}
?>
