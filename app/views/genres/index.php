<?php require APPROOT.'/views/inc/top.php'; ?>
    <body class="page-blog">
        <?php require APPROOT.'/views/inc/header.php'; ?>



        <main id="main">

            <!-- ======= Breadcrumbs ======= -->
            <div class="breadcrumbs d-flex align-items-center" style="background-image: url('<?= URLROOT ?>/assets/img/blog-header.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center">

                <h2>DJConnect</h2>
                <ol>
                <li><a href="<?= URLROOT ?>/">DJConnect</a></li>
                <li>Home</li>
                </ol>

            </div>
            </div><!-- End Breadcrumbs -->

            <!-- ======= Blog Section ======= -->
            <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">

                <div class="row g-5">

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                    <div class="row gy-5 posts-list">
                        <ol class="list-group list-group-numbered ">


                            <?php foreach($data['genres'] as $genre): ?>

                            <li class="list-group-item d-flex justify-content-between align-items-start">

                                <div class="ms-2 me-auto">
                                <a href="<?= Redirect::link('genres', $genre->title, 'page', 1) ?>">
                                    <?= ucwords($genre->title) ?>
                                </a>
                                </div>
                                <span class="badge bg-primary rounded-pill"><?= $genre->counts ?></span>
                            </li>
                            <?php endforeach; ?>

                        </ol>

                    </div><!-- End blog posts list -->

                </div>

                <?php 
                        if(Logged::in()){
                            if(Session::check('privilege', 'admin')){
                                require APPROOT.'/views/inc/admin_sidebar.php'; 
                            }else{
                                require APPROOT.'/views/inc/user_sidebar.php'; 
                            }
                        }else{
                            require APPROOT.'/views/inc/sidebar.php'; 
                        }
                    ?>
              

                </div>

            </div>
            </section><!-- End Blog Section -->

        </main><!-- End #main -->

    <?php require APPROOT.'/views/inc/footer.php'; ?>
<?php require APPROOT.'/views/inc/bottom.php'; ?>