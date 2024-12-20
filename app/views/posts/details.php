<?php require APPROOT.'/views/inc/top.php'; ?>
    <body class="page-blog">
        <?php require APPROOT.'/views/inc/header.php'; ?>


  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('<?= URLROOT ?>/assets/img/blog-header.jpg');">
      <div class="container position-relative d-flex flex-column align-items-center">

        <h2>Post Details</h2>
        <ol>
          <li><a href="<?= URLROOT ?>"><?= SITENAME ?></a></li>
          <li>Details</li>
        </ol>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Blog Details Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row g-5">

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

            <article class="blog-details">

            <?php if(Logged::in() && (Session::check('id', $data['user']->id) || Session::check('email', $data['user']->email))): ?>

              <div class="d-grid gap-2 col-6 mx-auto mb-5">
                <a href="<?=Redirect::link('posts/edit/'.str_replace(' ','-', $data['post']->title).'/'.$data['post']->id) ?>" class="btn btn-primary">Edit Post</a>
              </div>

              <?php endif; ?>

              <div class="post-img text-center mt-3 rounded mx-auto d-block">
                <img src="<?= Media::cover($data['post']->cover_name) ?>" alt="Mix Cover" class="img-fluid">

              </div>

              <h2 class="title mt-5"><?= $data['post']->title ?></h2>

              <div class="meta-top">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="<?= Redirect::link('profile/'.$data['user']->username)?>"><?= $data['user']->name ?></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i><?= date('d M, Y',strtotime($data['post']->created_at)) ?></li>
                  <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i><?= count($data['comments']) ?> Comments</li>
                  <li class="d-flex align-items-center"><i class="bi bi-music-note-list"></i> <a href="<?= Redirect::link('post/genre/'.$data['genre']->title) ?>"><?= $data['genre']->title ?></a></li>

                  <?php  if($data['post']->mix_type == 'audio/mpeg'): ?>
                    <li class="d-flex align-items-center"><i class="bi bi-file-earmark-music"></i> <a href="<?= Redirect::link('audio'.$data['genre']->title) ?>"> Audio</a></li>
                  <?php elseif($data['post']->mix_type == 'video/mp4'): ?>
                    <li class="d-flex align-items-center"><i class="bi bi-camera-video"></i> <a href="<?= Redirect::link('video'.$data['genre']->title) ?>"> Video</a></li>
                  <?php endif; ?>
                </ul>
              </div><!-- End meta top -->
             

              <div class="content">
                <h3>Description</h3>

                <p class="text-justify"><?= $data['post']->description ?></p>

                <h3>Mix</h3>
                  <div class="row">
                  <?php  if($data['post']->mix_type == 'audio/mpeg'): ?>
                    <audio controls  controlsList="nodownload">
                      <source src="<?= Media::audio($data['post']->mix_name) ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                  <?php elseif($data['post']->mix_type == 'video/mp4'): ?>
                    <video width="640" height="480" controls controlsList="nodownload">
                        <source src="<?= Media::video($data['post']->mix_name) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                  <?php endif; ?>


                  </div>
                <h3>TrackListings</h3>
                <p>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Track</th>
                            <th scope="col">Artist</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($data['post']->tracklist && 1)): ?>
                              <?php foreach($data['post']->tracklist as $tracklist): ?>
                                <tr>
                                  <th scope="row"><?= $tracklist->no ?></th>
                                  <td><?= $tracklist->track ?></td>
                                  <td><?= $tracklist->artist ?></td>
                                </tr>
                                <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                </p>
                

              </div><!-- End post content -->

            </article><!-- End blog post -->
            


            <?php if($data['profile']): ?>
            <div class="post-author d-flex align-items-center">
              <img src="<?= Media::avatar($data['profile']->avatar_name) ?>" class="rounded-circle flex-shrink-0" alt="">
              <div>
                <h4>
                  
                  <?php if(!empty($data['user']->username)): ?>
                  <a href="<?= Redirect::link('profile', $data['user']->username) ?>"><?= $data['user']->name ?></a>
                  <?php else: ?>
                    <a href="<?= Redirect::link('profile/dj/', $data['user']->id) ?>"><?= $data['user']->name ?></a>
                 <?php endif ?>
                
                </h4>
                <div class="social-links">
                  <?php if(!empty($data['profile']->x)): ?>
                  <a href="<?= $data['profile']->x ?>"><i class="bi bi-twitter-x"></i></a>
                  <?php endif ?>
                  <?php if(!empty($data['profile']->fb)): ?>
                  <a href="<?= $data['profile']->fb ?>"><i class="bi bi-facebook"></i></a>
                  <?php endif ?>
                  <?php if(!empty($data['profile']->ig)): ?>
                  <a href="<?= $data['profile']->ig ?>"><i class="bi bi-instagram"></i></a>
                  <?php endif ?>

                </div>
                <p class="text-justify"><?= $data['profile']->bio ?></p>
              </div>
            </div><!-- End post author -->
            <?php endif; ?>

            <div class="comments">

              <h4 class="comments-count"><?= count($data['comments']) ?> Comments</h4>

              <?php if(!empty($data['comments'])): ?>
                <?php foreach($data['comments'] as $comment): ?>

              <div id="comment-1" class="comment">
                <div class="d-flex">
                  <div class="comment-img"><img src="<?= Media::avatar($comment->name) ?>" alt=""></div>
                  <div>
                    <h5 class="lead"><?= ucwords($comment->name) ?></h5>
                    <time><?= Format::date($comment->created_at) ?></time>
                    <p class="text-justify"><?= ucfirst($comment->content) ?></p>
                  </div>
                </div>
              </div><!-- End comment #1 -->

              <?php endforeach; ?>

              <?php endif; ?>

              <div class="reply-form">

                <h4>Leave a Reply</h4>
                <p>Your email address will not be published. Required fields are marked * </p>
                <form action="" method="post">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input name="name" type="text" class="form-control" placeholder="Your Name*">
                    </div>
                    <div class="col-md-6 form-group">
                      <input name="email" type="text" class="form-control" placeholder="Your Email*">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <input name="website" type="text" class="form-control" placeholder="Your Website">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Post Comment</button>

                </form>

              </div>

            </div><!-- End blog comments -->

          </div>


          <?php 
                        if(Logged::in()){
                            if(Session::get('privilege') == 'admin'){
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
    </section><!-- End Blog Details Section -->

  </main><!-- End #main -->
  <?php require APPROOT.'/views/inc/footer.php'; ?>

  

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
<?php require APPROOT.'/views/inc/bottom.php'; ?>