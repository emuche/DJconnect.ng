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

                    <?php foreach($data['posts'] as $post): ?>
                    
                    <div class="col-md-6">
                        <article class="d-flex flex-column">

                        <div class="post-img">
                            <img src="<?= Media::cover($post->cover_name) ?>" alt="Album Cover" class="img-fluid">
                        </div>

                        <h2 class="title">
                            <a href="<?= Redirect::link('posts/details',$post->title,$post->postId) ?>"><?= $post->title ?></a>
                        </h2>

                        <div class="meta-top">
                            <ul class="justify-content-center m-1">
                            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="<?= Redirect::link('profile',$post->username) ?>"><?= $post->name ?></a></li>
                            <li class="d-flex align-items-center"><i class="bi bi-clock"></i><time datetime="01-01-2020"><?= Format::date($post->postCreatedAt) ?></time></li>
                            <li class="d-flex align-items-center"><i class="bi bi-music-note-list"></i> <a href="<?= Redirect::link('genres', $post->genre, $post->genreId) ?>"><?= $post->genre ?></a></li>


                            <?php  if($post->mix_type == 'audio/mpeg'): ?>
                                <li class="d-flex align-items-center"><i class="bi bi-file-earmark-music"></i> <a href="<?= Redirect::link('audios') ?>"> Audio</a></li>
                            <?php elseif($post->mix_type == 'video/mp4'): ?>
                                <li class="d-flex align-items-center"><i class="bi bi-camera-video"></i> <a href="<?= Redirect::link('videos') ?>"> Video</a></li>
                            <?php endif; ?>




                            <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i><?= $post->comments_count ?> Comments</li>
                            </ul>
                        </div>

                        <div class="content text-justify">
                            <p><?= substr($post->description, 0, 100) ?>...</p>
                        </div>

                        <div class="read-more mt-auto align-self-end">
                            <a href="<?= Redirect::link('posts/details', $post->title, $post->postId) ?>">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>

                        </article>
                    </div><!-- End post list item -->

                    <?php endforeach; ?>


                    </div><!-- End blog posts list -->

                    <div class="blog-pagination">
                    <ul class="justify-content-center">
                        <li class="active"><a href="<?= Redirect::link('audios/1') ?>">1</a></li>
                        <li><a href="<?= Redirect::link('audios/2') ?>">2</a></li>
                        <li><a href="<?= Redirect::link('audios/3') ?>">3</a></li>
                        <li><a href="<?= Redirect::link('audios/4') ?>">4</a></li>
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