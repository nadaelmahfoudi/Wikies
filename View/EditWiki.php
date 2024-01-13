<?php
require_once '../Model/WikiModel.php';

$wikiModel = new WikiModel();

$categories = $wikiModel->getAllCategories();
if (isset($_GET['id'])) {
    $wikiId = $_GET['id'];
    $wikiEntry = $wikiModel->selectRecords('wiki', 'id = ' . $wikiId);

    if (empty($wikiEntry)) {
        echo 'Wiki entry not found';
        exit;
    }
     

    $wikiEntry = $wikiEntry[0];
} else {
    echo 'Wiki ID not provided';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $dateCreate = date('Y-m-d H:i:s');
    $status = $_POST['status'];
    $description = $_POST['description'];
    $user_id = $_POST['user_id'];
    $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;

    // Update the Wiki entry
    $result = $wikiModel->updateWikiEntry($wikiId, $title, $content,$dateCreate ,$status, $description, $user_id, $categoryId);

    if ($result) {
        header('Location: Wiki.php');
        exit;
    } else {
        echo 'Error updating wiki entry.';
    }
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
    <?php require_once 'include/nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Edit Wiki Entry</h2>

                <form method="post" action="">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $wikiEntry['title'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required><?= $wikiEntry['content'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <?php
                            foreach ($categories as $category) {
                                $selected = ($category['id'] == $wikiEntry['category_id']) ? 'selected' : '';
                                echo "<option value='{$category['id']}' $selected>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="datecreate" class="form-label">Datecreate</label>
                        <input type="text" class="form-control" id="datecreate" name="datecreate" value="<?= $wikiEntry['datecreate'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">status</label>
                        <input type="text" class="form-control" id="status" name="status" value="<?= $wikiEntry['status'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">description</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?= $wikiEntry['description'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">user_id</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?= $wikiEntry['user_id'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">category_id</label>
                        <input type="text" class="form-control" id="category_id" name="category_id" value="<?= $wikiEntry['category_id'] ?>" required>
                    </div>

                    <button type="submit" value="submit" class="btn btn-primary">Update Wiki Entry</button>
                </form>
            </main>
        </div>
    </div>
</body>
</html>