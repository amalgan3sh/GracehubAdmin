<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Dashboard Selection - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Dashboard Selection for Super Admin" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
</head>

<body id="body" class="auth-page" style="background-image: url('assets/images/p-1.png'); background-size: cover; background-position: center center;">

<?php if (isset($showLoader) && $showLoader): ?>
    <?= view('loader/loader'); ?>
<?php endif; ?>
    <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                             <img src="assets/images/ARANEA_WHITE.png" height="100" alt="logo" class="auth-logo">
                                        </a>
                                        <?php $session = session(); ?>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Welcome, <?= $session->get('username') ?>!</h4>   
                                        <p class="text-muted mb-0">Please select the dashboard you'd like to access.</p>  
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Healthcare Card (i1) -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-hospital fa-3x mb-3 text-primary"></i>
                                                    <h5 class="card-title">Healthcare (i1)</h5>
                                                    <p class="card-text">Access the Healthcare dashboard</p>
                                                    <a href="<?php echo base_url('healthcare_dashboard') ?>" class="btn btn-primary">Go to Healthcare</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- HolidayCity Card (i2) -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-umbrella-beach fa-3x mb-3 text-success"></i>
                                                    <h5 class="card-title">HolidayCity (i2)</h5>
                                                    <p class="card-text">Access the HolidayCity dashboard</p>
                                                    <a href="<?php echo base_url('holiday_dashboard') ?>" class="btn btn-success">Go to HolidayCity</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Barter Card (i3) -->
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-exchange-alt fa-3x mb-3 text-info"></i>
                                                    <h5 class="card-title">Barter (i3)</h5>
                                                    <p class="card-text">Access the Barter dashboard</p>
                                                    <a href="<?php echo base_url('barter_dashboard') ?>" class="btn btn-info">Go to Barter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light-alt text-center">
                                    &copy; <script>
                                        document.write(new Date().getFullYear())
                                    </script> Aranea                                          
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <!-- vendor js -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/loader.js"></script>
</body>

</html>