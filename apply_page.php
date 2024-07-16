<?php include("php_connections/add_applicant.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Apply for <?php echo htmlspecialchars($job_title); ?></title>
    <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
    <link rel="stylesheet" type="text/css" href="assets/css/style_applyform_page.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style_applyform_page.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/0dcd39d035.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
</head>

<body class="scrollbar" id="style-5">
    <div class="force-overflow">
        <!-- Navbar -->
        <?php include("navbar.php"); ?>
        <!-- End of Navbar -->
        <div class="col-md-6">
            <!-- Empty column to create space -->
        </div>

        <section id="apply-job">
            <div class="container mt-5">
                <h2 class="mb-4">Apply for <?php echo htmlspecialchars($job_title); ?></h2>
                <p>Please note: Only PDF files are allowed, and the maximum file size for each upload is 5MB.</p>
                <!-- FORM -->
                <form method="post"
                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?job_id=" . $job_id); ?>"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Lastname<span class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Firstname <span class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="middlename" class="form-label">Middlename <span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="middlename" id="middlename" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sex <span class="red-asterisk">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" id="male" value="male" required>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" id="female" value="female"
                                    required>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address <span class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="address" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="red-asterisk">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Number <span
                                class="red-asterisk">*</span></label>
                        <input type="tel" class="form-control" name="contact_number" id="contact" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Course <span class="red-asterisk">*</span></label>
                        <input type="c" class="form-control" name="course" id="course" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Years Of Experience<span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="years_of_experience" id="years_of_experience"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Hours Of Trainings <span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="hours_of_training" id="hours_of_training" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Eligibility <span class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="eligibility" id="eligibility" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">List Of Awards <span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="list_of_awards" id="list_of_awards" required>
                    </div>


                    <div class="mb-3">
                        <label for="application_letter" class="form-label">Application Letter <span
                                class="red-asterisk">*</span></label>
                        <input type="file" class="form-control" name="application_letter" id="application_letter"
                            accept="application/pdf" required>
                    </div>

                    <div class="mb-3">
                        <label for="pds" class="form-label">Fully accomplished Personal Data Sheet with recent
                            passport-sized picture <span class="red-asterisk">*</span></label>
                        <input type="file" class="form-control" name="pds" id="pds" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="performance_rating" class="form-label">Performance rating in the last rating period
                            (if applicable)</label>
                        <input type="file" class="form-control" name="performance_rating" id="performance_rating"
                            accept="application/pdf">
                    </div>
                    <div class="mb-3">
                        <label for="certificate_eligibility" class="form-label">Photocopy of certificate of
                            eligibility/rating/license <span class="red-asterisk">*</span></label>
                        <input type="file" class="form-control" name="certificate_eligibility"
                            id="certificate_eligibility" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="transcript_records" class="form-label">Photocopy of Transcript of Records <span
                                class="red-asterisk">*</span></label>
                        <input type="file" class="form-control" name="transcript_records" id="transcript_records"
                            accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="certificate_employment" class="form-label">Photocopy of Certificate of Employment/s
                            <span class="red-asterisk">*</span></label>
                        <input type="file" class="form-control" name="certificate_employment"
                            id="certificate_employment" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="trainings_seminars" class="form-label">Proof of trainings and seminars attended
                            <span class="red-asterisk">*</span></label>
                        <input type="file" class="form-control" name="trainings_seminars" id="trainings_seminars"
                            accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="awards" class="form-label">Proof of awards received (if applicable)</label>
                        <input type="file" class="form-control" name="awards" id="awards" accept="application/pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </form>
            </div>

        </section>
        <div class="col-md-6 mt-3">
            <!-- Empty column to create space -->
        </div>
        <?php include("footer.php") ?>
    </div>
</body>

</html>