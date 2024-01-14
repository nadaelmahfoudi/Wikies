<?php
include '../Model/WikiModel.php';
$wikiModel = new WikiModel();

$wikiId = isset($_GET['id']) ? $_GET['id'] : '';

$wikiDetails = $wikiModel->singlePageDetail($wikiId);
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
<?php require_once 'include/nav.php'?>


<div class="container mt-4">
    <div class="jumbotron">
        <h1 class="display-4">Wiki Details</h1>
    </div>

    <?php if (!empty($wikiDetails)): ?>
        <div class="card">
            <div class="card-header">
                <h2><?php echo htmlspecialchars($wikiDetails['title']); ?></h2>
            </div>
            <div class="card-body">
                <h5 class="card-title">Author: <?php echo htmlspecialchars($wikiDetails['author']); ?></h5>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($wikiDetails['content'])); ?></p>
                <p>Date Created: <?php echo htmlspecialchars($wikiDetails['datecreate']); ?></p>
                <p>Description: <?php echo htmlspecialchars($wikiDetails['description']); ?></p>
                <p>Category: <span class="badge bg-primary"><?php echo htmlspecialchars($wikiDetails['category']); ?></span></p>
                <?php if (!empty($wikiDetails['tags'])): ?>
                    <p>Tags:
                        <?php foreach (explode(', ', $wikiDetails['tags']) as $tag): ?>
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Wiki details not found.
        </div>
    <?php endif; ?>
</div>

    <!-- Add your JS scripts or link to external scripts here -->
</body>
</html>
