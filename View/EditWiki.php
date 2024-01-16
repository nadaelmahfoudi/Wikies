<?php



// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $title = $_POST['title'];
//     $content = $_POST['content'];
//     $dateCreate = date('Y-m-d H:i:s');
//     $status = $_POST['status'];
//     $description = $_POST['description'];
//     $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;

//     // Update the Wiki entry
//     $result = $wikiModel->updateWikiEntry($wikiId, $title, $content,$dateCreate ,$status, $description, $user_id, $categoryId);

//     if ($result) {
//         header('Location: Wiki.php');
//         exit;
//     } else {
//         echo 'Error updating wiki entry.';
//     }
// }
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

                <form method="post" >
                <input type="hidden" name="id" value="<?= $wikiId ?>">
                    <div class="mb-3">
                    
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
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
                        <label for="dateCreate" class="form-label">Date Created</label>
                        <input type="datetime-local" class="form-control" id="dateCreate" name="datecreate" value="" required>
                    </div>


                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="" required>
                    </div>



                    <button type="submit" value="submit" class="btn btn-primary">Update Wiki Entry</button>
                </form>
            </main>
        </div>
    </div>
</body>
</html>
