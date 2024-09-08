<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    

    <meta charset="utf-8" />
            <title>Sanctify - Admin & Dashboard</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />

            <!-- App favicon -->
            <link rel="shortcut icon" href="assets/images/favicon.ico">

       

     <!-- App css -->
     <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
     <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
     

</head>

<body id="body" class="auth-page" style="background-image: url('assets/images/p-1.png'); background-size: cover; background-position: center center;">
   <!-- Log In page -->
   <?php if (isset($showLoader) && $showLoader): ?>
    <?= view('loader/loader'); ?>
<?php endif; ?>
   

    <div class="container-md" id="content">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="assets/images/ARANEA_WHITE.png" height="100" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Let's Get Started Sanctify</h4>   
                                        <p class="text-muted  mb-0">Sign in to continue to Sanctify.</p>  
                                    </div>
                                </div>
                                <div class="card-body pt-0">                                    
                                <form id="loginForm" class="my-4" action="<?= base_url('verify_login') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?= old('username') ?>">
                                        <?php if (isset($errors['username'])): ?>
                                            <div class="text-danger"><?= $errors['username'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">
                                        <?php if (isset($errors['password'])): ?>
                                            <div class="text-danger"><?= $errors['password'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid mt-3">
                                                <button class="btn btn-primary" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                    <div class="m-3 text-center text-muted">
                                        <p class="mb-0">Don't have an account ?  <a href="register" class="text-primary ms-2">Free Resister</a></p>
                                    </div>
                                    <hr class="hr-dashed mt-4">
                                    <div class="text-center mt-n5">
                                        <h6 class="card-bg px-3 my-4 d-inline-block">Or Login With</h6>
                                    </div>
                                    <div class="d-flex justify-content-center mb-1">
                                        <a href="" class="d-flex justify-content-center align-items-center thumb-sm bg-soft-primary rounded-circle me-2">
                                            <i class="fab fa-facebook align-self-center"></i>
                                        </a>
                                        <a href="" class="d-flex justify-content-center align-items-center thumb-sm bg-soft-info rounded-circle me-2">
                                            <i class="fab fa-twitter align-self-center"></i>
                                        </a>
                                        <a href="" class="d-flex justify-content-center align-items-center thumb-sm bg-soft-danger rounded-circle">
                                            <i class="fab fa-google align-self-center"></i>
                                        </a>
                                    </div>
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

 <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/loader.js"></script>

    
</body>

</html>