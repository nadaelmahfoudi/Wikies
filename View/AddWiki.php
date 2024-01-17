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
<?php require_once 'include/nav.php'?>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar ">
        </nav>

<!-- Add Wiki Entry Form -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Add Wiki Entry</h2>

    <form method="post" action="?page=Wiki&action=addWikiEntry"  onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" >
                <?php
                foreach ($categories as $category) {
                    echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="row">
    <?php $count = 0; ?>
    <?php foreach ($tags as $tag) : ?>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="<?= $tag['id'] ?>" name="tags[]" id="flexCheckDefault<?= $count ?>">
                <label class="form-check-label" for="flexCheckDefault<?= $count ?>">
                    <?= $tag['tag_name'] ?>
                </label>
            </div>
        </div>
        <?php if (++$count % 2 == 0) : ?>
            </div>
            <?php if ($count < count($tags)) : ?>
                <div class="row">
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
 




        <div class="mb-3">
            <label for="dateCreate" class="form-label">Date Created</label>
            <input type="datetime-local" class="form-control" id="dateCreate" name="datecreate" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <button type="submit" value="submit" class="btn btn-primary">Add Wiki Entry</button>

    </form>
</main>
<!-- End Add Wiki Entry Form -->
<script>
    function validateForm() {
        var title = document.getElementById('title').value;
        var content = document.getElementById('content').value;

        // Réinitialiser les messages d'erreur
        document.getElementById('titleError').innerHTML = '';
        document.getElementById('contentError').innerHTML = '';

        var isValid = true;

        // Validation du titre
        if (title.trim() === '') {
            document.getElementById('titleError').innerHTML = 'Veuillez entrer un titre.';
            isValid = false;
        } else if (title.length > 30) {
            document.getElementById('titleError').innerHTML = 'Le titre ne doit pas dépasser 30 caractères.';
            isValid = false;
        }

        // Validation du contenu
        if (content.trim() === '') {
            document.getElementById('contentError').innerHTML = 'Veuillez entrer du contenu.';
            isValid = false;
        }

        

        return isValid; 
    }
</script>

</body>
</html>

</body>
</html>