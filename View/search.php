<div class="row" id="showdata" >
        <?php if(isset($wikies) && !empty($wikies)): ?>
            <?php foreach ($wikies as $wikie): ?>
                <div class="col-lg-6 col-12">
                    <div class="custom-block custom-block-overlay">
                        <div class="d-flex flex-column h-100">
                            <img src="images/businesswoman-using-tablet-analysis.jpg" class="custom-block-image img-fluid" alt="">

                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                    <div class="custom-block bg-white shadow-lg">
                                        <a href="single_pageWiki.php?id=<?php echo $wikie['id']; ?>&action=getWikiDetails">
                                            <div class="d-flex">
                                                <div>
                                                    <h5 class="mb-2"><?php echo $wikie['title']; ?></h5>
                                                    <p class="mb-0"><?php echo $wikie['content']; ?></p>
                                                    <p class="mb-0"><?php echo $wikie['datecreate']; ?></p>
                                                </div>
                                            </div>
                                            <span class="badge bg-design rounded-pill ms-auto">14</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="section-overlay"></div>
                            <a href="single_pageWiki.php?id=<?php echo $wikie['id']; ?>&action=getWikiDetails" class="btn btn-primary mt-3">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No wiki entries found.</p>
        <?php endif; ?>
    </div>