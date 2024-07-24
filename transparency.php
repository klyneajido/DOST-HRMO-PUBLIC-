<?php include("php_connections/fetch_documents.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Transparency Documents</title>
    <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
    <link rel="stylesheet" type="text/css" href="assets/css/transparency.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/0dcd39d035.js" crossorigin="anonymous"></script>
    <style>
        .document-item {
            margin-bottom: 30px;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>

<body class="scrollbar" id="style-5">
    <div class="force-overflow transparency-container">
        <!-- Navbar -->
        <?php include("navbar.php"); ?>
        <!-- End of Navbar -->
        <div class="container mt-5">
            <!-- Search Bar -->
            <div class="search-bar shadow-sm p-4 mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search for documents..." onkeyup="filterDocuments()">
            </div>

            <div class="row" id="documentList">
                <?php if (!empty($documents)): ?>
                    <?php foreach ($documents as $document): ?>
                        <div class="col-lg-6 col-md-12 document-item">
                            <div class="card border-0 bg-light shadow-sm">
                                <div class="card-body">
                                    <h6><?php echo htmlspecialchars($document['name']); ?></h6>
                                    <div class="mt-3">
                                        <a href="download_document.php?id=<?php echo $document['doc_id']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 d-flex justify-content-center mt-4">
                        <div class="card border-0 bg-light rounded shadow">
                            <div class="card-body text-center">
                                <h6>No Documents Available</h6>
                                <p class="text-muted mb-0">Currently, there are no documents available for download.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div><!-- end row -->
            <div id="noDocuments" class="no-documents">
                <h6>No documents found</h6>
                <p class="text-muted mb-0">Try adjusting your search criteria.</p>
            </div>
        </div><!-- end container -->

        <script src="assets/js/transparency.js"></script>
    </div>
        <!-- Site footer -->
        <div id="footer"><?php include("footer.php")?></div>
</body>

</html>
