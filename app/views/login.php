<?php require APPROOT.'/views/inc/top.php'; ?>
    <body class="page-blog">
        <?php require APPROOT.'/views/inc/header.php'; ?>

        <main id="main">

            <!-- ======= Breadcrumbs ======= -->
            <div class="breadcrumbs d-flex align-items-center" style="background-image: url('<?= URLROOT ?>/assets/img/blog-header.jpg')">
            <div class="container position-relative d-flex flex-column align-items-center">

                <h2>Login</h2>
                <ol>
                <li><a href="<?= URLROOT ?>/">DJConnect</a></li>
                <li>Login</li>
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

                            <div class="col mx-auto">

                                <?php if(Session::exists('register_success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= Session::flash('register_success') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if(Session::exists('failed_login')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= Session::flash('failed_login') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>



                                <div class="card card-body bg-light mt-5">
                                    <h2>Login</h2>
                                    <p>Please fill in your credentials to login.</p>
                                    <p><?= isset($data['register']) ? $data['register'] : ''?></p>
                                    <form action="<?= URLROOT ?>/login" method="post">
                                    <div class="">
                                        <label>Email/Username:<sup>*</sup></label>
                                        <input type="text" name="email" class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?>">
                                        <span class="invalid-feedback"><?= $data['email_err'] ?></span>
                                    </div>    
                                    <div class="">
                                        <label>Password:<sup>*</sup></label>
                                        <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['password'] ?>">
                                        <span class="invalid-feedback"><?= $data['password_err'] ?></span>
                                    </div>
                                    <div class="row mt-3 ">
                                        <div class="col">
                                        <input type="submit" class="btn btn-success btn-block" value="Login">
                                        </div>
                                        <div class="col">
                                        <a href="<?= URLROOT ?>/forgotpassword" class="btn btn-light btn-block">Forgot Password?</a>
                                        </div>
                                        <div class="col">
                                        <a href="<?= URLROOT ?>/register" class="btn btn-light btn-block">No account? Register</a>
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