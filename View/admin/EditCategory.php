
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
<?php require_once 'View/include/nav.php' ?>

<div class="container-fluid">
    <div class="row">

        <!-- Edit Category Form -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>Edit Category</h2>

            <form method="POST" action="?page=Categorie&action=updateCategory">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?= $categoryName ?>" required>
                    <input type="hidden" name="category_id" value="<?= $categoryId ?>">
                </div>
                <button type="submit" value="submit" class="btn btn-primary">Update Category</button>
            </form>
        </main>
        <!-- End Edit Category Form -->

    </div>
</div>
</body>
</html>
