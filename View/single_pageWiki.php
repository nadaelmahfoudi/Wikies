<?php
include '../Model/WikiModel.php'; 
$wikiModel = new WikiModel();

// Fetch $wikiId from the URL
$wikiId = isset($_GET['id']) ? $_GET['id'] : '';

$wikiDetails = $wikiModel->getWikiDetails($wikiId);
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

    <div class="container">
        <h2>Wiki Details</h2>
        <?php if (isset($wikiDetails) && !empty($wikiDetails)): ?>
            <p>Title: <?php echo $wikiDetails['title']; ?></p>
            <p>Content: <?php echo $wikiDetails['content']; ?></p>
            <p>Date Created: <?php echo $wikiDetails['datecreate']; ?></p>
            <p>Description: <?php echo $wikiDetails['description']; ?></p>
            <p>Category ID: <?php echo $wikiDetails['category_id']; ?></p>
            
            <?php if (isset($wikiDetails['tags']) && !empty($wikiDetails['tags'])): ?>
                <p>Tags: <?php echo implode(', ', $wikiDetails['tags']); ?></p>
            <?php endif; ?>

            
            
            <!-- Add more details as needed -->
        <?php else: ?>
            <?php var_dump($wikiDetails);?>
            <p>Wiki details not found.</p>
        <?php endif; ?>
    </div>

    <!-- Add your JS scripts or link to external scripts here -->
</body>
</html>
