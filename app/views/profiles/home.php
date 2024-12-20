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

                    <?php foreach($data['djs'] as $dj): ?>
                    
                    <div class="col-md-6 text-justify">
                        <article class="d-flex flex-column text-justify">

                        <div class="post-img">
                            <img src="<?= Media::avatar($dj->avatar_name) ?>" alt="Album Cover" class="img-fluid">
                        </div>

                        <h2 class="title">
                            <a href="<?= Redirect::link('profiles', $dj->username) ?>"><?= $dj->name ?> : <?= $dj->username ?></a>
                        </h2>

                        <div class="meta-top">
                            <ul class="justify-content-center m-1">
                                <li class="d-flex align-items-center">Registration Date: <?= Format::date($dj->userCreatedAt) ?></li>
                            </ul>
                        </div>

                        </article>
                    </div>

                    <?php endforeach; ?>


                    </div><!-- End blog posts list -->

                    <div class="blog-pagination">
                    <ul class="justify-content-center">
                        <li class="active"><a href="<?= Redirect::link('profiles/home/1') ?>">1</a></li>
                        <li><a href="<?= Redirect::link('profiles/home/2') ?>">2</a></li>
                        <li><a href="<?= Redirect::link('profiles/home/3') ?>">3</a></li>
                        <li><a href="<?= Redirect::link('profiles/home/4') ?>">4</a></li>
                    </ul>
                    </div><!-- End blog pagination -->

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