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
        <!-- Sidebar -->
        <?php require_once 'include/side_bare.php'?>
        <!-- End Sidebar -->

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>Wiki Entries</h2>

        <!-- Table for Wikies -->
        <div>
            Number of Wikies: <?= count($wikies); ?>
        </div>
        <table class="table">
            <a href="?page=Wiki&action=addWikiEntry">Add Wiki</a>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Status</th>
                    <th scope="col">Description</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Category ID</th>
                    <th scope="col">Tags</th> <!-- Added Tags column -->
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wikies as $wikie): ?>
                    <tr>
                        <th scope="row"><?= $wikie['id'] ?></th>
                        <td><?= $wikie['title'] ?></td>
                        <td><?= $wikie['content'] ?></td>
                        <td><?= $wikie['datecreate'] ?></td>
                        <td><?= $wikie['status'] ?></td>
                        <td><?= $wikie['description'] ?></td>
                        <td><?= $wikie['user_id'] ?></td>
                        <td><?= $wikie['category_id'] ?></td>
                        <td>
                            <?php
                            // Fetch and display tags for the current wiki entry
                            $tags = isset($wikie['tags']) ? $wikie['tags'] : [];
                            echo implode(', ', $tags);
                            ?>
                        </td>
                        <td>
                        <form method="post" action="?page=Wiki&action=updateWikiStatus&id=<?= $wikie['id'] ?>">
                            <select name="newStatus" class="form-select" aria-label="Default select example">
                                <option value="0" <?= $wikie['status'] == 0 ? 'selected' : '' ?>>En attente</option>
                                <option value="1" <?= $wikie['status'] == 1 ? 'selected' : '' ?>>Affiché</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Accepter</button>
                        </form>
                            <a href="?page=Wiki&action=updateWikiEntry&id=<?= $wikie['id'] ?>">Edit</a>
                            <a href="?page=Wiki&action=deleteWikiEntry&id=<?= $wikie['id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- End Table for Wikies -->


        </main>
        <!-- End Main content -->

    </div>
</div>

<!-- Bootstrap JS and other scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
></script>
</body>
</html>
