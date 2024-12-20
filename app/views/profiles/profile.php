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

              
            <?php endif; ?>

              <div class="post-img text-center mt-3 rounded mx-auto d-block">
                <img src="<?= Media::avatar($data['profile']->avatar_name) ?>" alt="Avatar" class="img-fluid">

              </div>

              <h2 class="title mt-5">Full Name: <?= $data['dj']->name ?></h2>
              <h4 class="title mt-5">Username: <?= $data['dj']->username ?></h4>

              <div class="meta-top">
                <ul>
                  <li class="d-flex align-items-center">Registration Date:   <i class="bi bi-clock"> </i><?= Format::date($data['dj']->created_at) ?></li>
                </ul>
                <br>
                  <a href="<?= Redirect::link('profiles', $data['dj']->username, 1)?>" class="lead fs-5">All <?= $data['dj']->name ?>'s <strong>Mixtapes</strong></a><br><br>
                  <a href="<?= Redirect::link('profiles', $data['dj']->username, 'audios', 1)?>" class="lead fs-5">All <?= $data['dj']->name ?>'s <strong>Audios</strong></a><br><br>
                  <a href="<?= Redirect::link('profiles', $data['dj']->username, 'videos', 1)?>" class="lead fs-5">All <?= $data['dj']->name ?>'s <strong>Videos</strong></a><br><br>
             

              <div class="content">
                <h3>Profile</h3>
                <p>
                    <table class="table">
                        <tbody>
                                <tr>
                                  <th scope="row">Name: </th>
                                  <td><?= $data['dj']->name ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Username: </th>
                                  <td><?= $data['dj']->username ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Email: </th>
                                  <td><?= $data['dj']->email ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Bio: </th>
                                  <td><?= $data['profile']->bio ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Phone Number: </th>
                                  <td><?= $data['profile']->phone ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Address: </th>
                                  <td><?= $data['profile']->address ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">twitter-X Profile: </th>
                                  <td><?= $data['profile']->x ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Facebook Profile: </th>
                                  <td><?= $data['profile']->fb ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Instagram Profile: </th>
                                  <td><?= $data['profile']->ig ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">DJ's Website: </th>
                                  <td><?= $data['profile']->web ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">City: </th>
                                  <td><?= $data['profile']->city ?></td>
                                </tr>
                        </tbody>
                      </table>
                </p>
                

              </div><!-- End post content -->

            </article><!-- End blog post -->
            


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