<div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">

            <div class="sidebar ps-lg-4">

              <div class="sidebar-item search-form">
                <h3 class="sidebar-title">Search</h3>
                <form action="" class="mt-3">
                  <input type="text">
                  <button type="submit"><i class="bi bi-search"></i></button>
                </form>
              </div><!-- End sidebar search formn-->

              <div class="sidebar-item categories">
                <h3 class="sidebar-title">My Menu</h3>
                <ul class="mt-3">
                  <li><a href="<?= Redirect::link('posts') ?>">All Posts <span>(<?= ($data['post_count']) ?>)</span></a></li>
                  <li><a href="<?= Redirect::link('posts/audios') ?>">My Audios </a></li>
                  <li><a href="<?= Redirect::link('posts/videos') ?>">My Videos </a></li>
                  <li><a href="<?= Redirect::link('posts/genres') ?>">My Genres </a></li>
                  <li><a href="<?= Redirect::link('posts/add') ?>">Add Post</a></li>
                </ul>
              </div>

              <div class="sidebar-item categories">
                <h3 class="sidebar-title">Categories</h3>
                <ul class="mt-3">
                <?php foreach($data['categories'] as $category):?>
                  <li><a href="<?= Redirect::link('home/genre', $category->title, $category->id) ?>"><?= $category->title ?><span>(<?= $category->counts ?>)</span></a></li>
                  <?php endforeach; ?>
                </ul>
              </div><!-- End sidebar categories-->

              <div class="sidebar-item recent-posts">
                <h3 class="sidebar-title">Recent Posts</h3>

                <div class="mt-3">

                <?php foreach($data['recent_posts'] as $recent):?>

                  <div class="post-item mt-3">
                    <img src="<?= Media::cover($recent->cover_name) ?>" alt="" class="flex-shrink-0">
                    <div>
                      <h4><a href="<?= Redirect::link('posts/details', $recent->title, $recent->id) ?>"><?= $recent->title ?></a></h4>
                      <time><?= Format::date($recent->created_at) ?></time>
                    </div>
                  </div><!-- End recent post item-->

                  <?php endforeach; ?>
                </div>

              </div><!-- End sidebar recent posts-->

            </div><!-- End Blog Sidebar -->

          </div>