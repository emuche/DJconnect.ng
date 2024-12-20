<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="<?= URLROOT ?>/" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="d-flex align-items-center"><?= SITENAME ?></h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

      <nav id="navbar" class="navbar">
        <ul>
         
          <?php if(Logged::in()): ?>
          <li><a href="<?= URLROOT ?>/profiles/<?= !empty(Session::get('username')) ? Session::get('username') : '' ?>"><?= ucwords(Session::get('name')) ?><i class="bi-person-fill" style="font-size: 1.3rem;"></i></a></li>
          <li><a href="<?= URLROOT ?>/profiles/home">DJs</a></li>
          <li><a href="<?= URLROOT ?>/videos">Videos</a></li>
          <li><a href="<?= URLROOT ?>/audios">Audios</a></li>
          <li><a href="<?= URLROOT ?>/genres">Genres</a></li>
          <li><a href="<?= URLROOT ?>/contact">Contact</a></li>
          <li><a href="<?= URLROOT ?>/about">About</a></li>
          <li><a href="<?= URLROOT ?>/logout">Logout</a></li>
          <?php else: ?>
            <li><a href="<?= URLROOT ?>/profiles/home">DJs</a></li>
            <li><a href="<?= URLROOT ?>/videos">Videos</a></li>
            <li><a href="<?= URLROOT ?>/audios">Audios</a></li>
            <li><a href="<?= URLROOT ?>/genres">Genres</a></li>
            <li><a href="<?= URLROOT ?>/contact">Contact</a></li>
            <li><a href="<?= URLROOT ?>/about">About</a></li>
            <li><a href="<?= URLROOT ?>/login">Account<i class="bi-person-fill" style="font-size: 1.3rem;"></i></a></li>
          
          <?php endif; ?>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

 