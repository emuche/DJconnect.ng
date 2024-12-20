<?php require APPROOT.'/views/inc/top.php'; ?>
    <body class="page-blog">
        <?php require APPROOT.'/views/inc/header.php'; ?>

        <main id="main">

            <!-- ======= Breadcrumbs ======= -->
            <div class="breadcrumbs d-flex align-items-center" style="background-image: url('<?= URLROOT ?>/assets/img/blog-header.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center">

                <h2>Register</h2>
                <ol>
                <li><a href="<?= URLROOT ?>/">DJConnect</a></li>
                <li>Register</li>
                </ol>

            </div>
            </div><!-- End Breadcrumbs -->

            <!-- ======= Blog Section ======= -->
            <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">

                <div class="row g-5">

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                    <div class="row gy-5 posts-list">

                        <div class="col-lg-10">

                            <div class="row">
                                <div class=" mx-auto">



                                <?php if(Session::exists('register_failed')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= Session::flash('register_failed') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>



                                    <div class="card card-body bg-light mt-5">
                                    <h2>Create An Account</h2>
                                    <p>Please fill this form to register with us</p>
                                    <form action="<?= URLROOT ?>/register" method="post">
                                        <div class="">
                                            <label>Name:<sup>*</label>
                                            <input type="text" name="name" class="form-control form-control-lg <?= (!empty($data['name_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['name'] ?>">
                                            <span class="invalid-feedback"><?= $data['name_err'] ?></span>
                                        </div> 
                                        <div class="">
                                            <label>Email Address:<sup>*</sup></label>
                                            <input type="text" name="email" class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?>">
                                            <span class="invalid-feedback"><?= $data['email_err'] ?></span>
                                        </div>    
                                        <div class="">
                                            <label>Password:<sup>*</sup></label>
                                            <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value="">
                                            <span class="invalid-feedback"><?= $data['password_err'] ?></span>
                                        </div>
                                        <div class="">
                                            <label>Confirm Password:<sup>*</sup></label>
                                            <input type="password" name="confirm_password" class="form-control form-control-lg <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : '' ?>" value="">
                                            <span class="invalid-feedback"><?= $data['confirm_password_err'] ?></span>
                                        </div>

                                        <div class="row  mt-3">
                                            <div class="col">
                                                <input type="submit" class="btn btn-success btn-block" value="Register">
                                            </div>
                                            <div class="col">
                                                <a href="<?= URLROOT ?>/forgotpassword" class="btn btn-light btn-block">Forgot Password?</a>
                                            </div>
                                            <div class="col">
                                                <a href="<?= URLROOT ?>/login" class="btn btn-light btn-block">Have an account? Login</a>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>

                            </div>


















                      
                        </div><!-- End post list item -->

                    </div><!-- End blog posts list -->

                </div>

                    <?php require APPROOT.'/views/inc/sidebar.php'; ?>

                </div>

            </div>
            </section><!-- End Blog Section -->

        </main><!-- End #main -->

    <?php require APPROOT.'/views/inc/footer.php'; ?>
<?php require APPROOT.'/views/inc/bottom.php'; ?>