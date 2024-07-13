
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <title>Joblist</title>
  <link rel="icon" type="image/png" href="assets/img/dost_logo.png">
  <link rel="stylesheet" type="text/css" href="assets/css/style_applyform_page.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />

  <script src="https://kit.fontawesome.com/0dcd39d035.js" crossorigin="anonymous"></script>

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
<div class="container form-container">
    <h2 class="text-center form-title">Job Application Form</h2>
    <form action="submit_application.php" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="applicant_id">Applicant ID</label>
                <input type="text" class="form-control" id="applicant_id" name="applicant_id" placeholder="Applicant ID">
            </div>
            <div class="form-group col-md-6">
                <label for="movement_id">Movement ID</label>
                <input type="text" class="form-control" id="movement_id" name="movement_id" placeholder="Movement ID">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
            </div>
            <div class="form-group col-md-4">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
            </div>
            <div class="form-group col-md-4">
                <label for="middlename">Middle Name</label>
                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="sex">Sex</label>
                <select class="form-control" id="sex" name="sex">
                    <option value="" selected disabled>Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="maritalstatus">Marital Status</label>
                <select class="form-control" id="maritalstatus" name="maritalstatus">
                    <option value="" selected disabled>Select</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact Number">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="emergency_id">Emergency Contact ID</label>
                <input type="text" class="form-control" id="emergency_id" name="emergency_id" placeholder="Emergency Contact ID">
            </div>
            <div class="form-group col-md-6">
                <label for="education_id">Education ID</label>
                <input type="text" class="form-control" id="education_id" name="education_id" placeholder="Education ID">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="eligibility_id">Eligibility ID</label>
                <input type="text" class="form-control" id="eligibility_id" name="eligibility_id" placeholder="Eligibility ID">
            </div>
            <div class="form-group col-md-6">
                <label for="emptraining_id">Employment Training ID</label>
                <input type="text" class="form-control" id="emptraining_id" name="emptraining_id" placeholder="Employment Training ID">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
    </form>
</div>
</section>
  </div>
  <script src="assets/js/script_joblist_page.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>