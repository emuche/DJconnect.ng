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
                    <li>Edit Post</li>
                    </ol>

                </div>
            </div><!-- End Breadcrumbs -->

            <!-- ======= Blog Section ======= -->
            <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">


                <div class="row g-5">

                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">

                    <div class="row gy-5 posts-list">
    
                    
                    <div class="row">
                                <div class=" mx-auto">



                                <?php if(Session::exists('upload_failed')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= Session::flash('upload_failed') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>



                                    <div class="card card-body bg-light mt-5">
                                       <div class="row">
                                        <div class="col">
                                                <h2>Edit Mixtape</h2>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-danger align-self-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Delete Post
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-justify">
                                                                <h5 class="modal-title text-justify" id="exampleModalLabel">Are you sure you want to delete this Post?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                <a href="<?= Redirect::link('posts', 'delete', $data['post']->title, $data['post']->id ) ?>" class="btn btn-danger">Delete Post</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                    <div class="text-center mt-3 rounded mx-auto d-block">
                                        <img src="<?= Media::cover($data['post']->cover_name) ?>" alt="" class="img-fluid">
                                    </div>

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
                                    <form action="<?= URLROOT ?>/posts/add" method="POST" enctype="multipart/form-data">
                                        <?= Csrf::generate() ?>
                                        <div class="m-4">
                                            <label><h4>Title:<sup>*</h4></sup></label>
                                            <input type="text" name="title" class="form-control form-control-lg <?= (!empty($data['title_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['title'] ?>">
                                            <span class="invalid-feedback"><?= $data['title_err'] ?></span>
                                        </div>
                                        <div class="m-4">
                                            <label><h4>Description:<sup>*</h4></sup></label>
                                            <textarea name="description" class="form-control <?= (!empty($data['description_err'])) ? 'is-invalid' : '' ?>" id="" rows="5"><?= $data['description'] ?></textarea>
                                            <span class="invalid-feedback"><?= $data['description_err'] ?></span>
                                        </div> 
                                        
                                        <div class="m-4">
                                            <label><h4>Mixtape:<sup>*</h4></sup></label>
                                            <input type="file" name="mixpath" class="form-control form-control-lg <?= (!empty($data['mixpath_err'])) ? 'is-invalid' : '' ?>" value="">
                                            <span class="invalid-feedback"><?= $data['mixpath_err'] ?></span>
                                        </div>
                                        <div class="m-4">
                                            <label><h4>Mixtape Cover:<sup>*</h4></sup></label>
                                            <input type="file" name="photopath" class="form-control form-control-lg <?= (!empty($data['photopath_err'])) ? 'is-invalid' : '' ?>" value="">
                                            <span class="invalid-feedback"><?= $data['photopath_err'] ?></span>
                                        </div>
                                        <div class="m-4">
                                            <label><h4>Genre:<sup>*</h4></sup></label>
                                            <select class="form-select <?= (!empty($data['genre_err'])) ? 'is-invalid' : '' ?>" name="genre">
                                                <option value="">Select Genre</option>
                                                <?= !empty($data['genre_value']) ? $data['genre_value'] : '' ?>


                                                <?php foreach($data['genres'] as $genre): ?>
                                                <option value="<?= $genre->id ?>"><?= $genre->title ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="invalid-feedback"><?= $data['genre_err'] ?></span>
                                        </div>
                                        <div class="m-4">
                                            <label><h4>Track Listing:</h4></label>
                                            
                                            <div class="row mb-4 mt-4">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Track Name</th>
                                                            <th scope="col">Artist</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(!empty($data['tracklist_values'])): ?>
                                                            <?php $count = count($data['tracklist_values']); $x = 0; ?>
                                                            <?php foreach($data['tracklist_values'] as $tracklist): ?>
                                                                <tr class="tracklist">
                                                                    <th scope="row"><?= $tracklist->no ?></th>
                                                                    <td><input type="text" name="track[]" id="" class="form-control" value="<?= $tracklist->track ?>"></td>
                                                                    <td><input type="text" name="artist[]" id="" class="form-control" value="<?= $tracklist->artist ?>"></td>
                                                                    <?php if($x == 0): ?>
                                                                    <td></td>
                                                                    <?php elseif($x == $count - 1): ?>
                                                                    <td class="add"><a href="" class="remove_track"><i class="bi bi-x-lg text-danger"></i></a></td>
                                                                    <?php else: ?>
                                                                    <td class="add"></td>
                                                                    <?php endif; ?>
                                                            </tr> 
                                                                <?php $x++; ?>
                                                            <?php endforeach; ?> 
                                                        <?php else: ?>
                                                            <tr class="tracklist">
                                                                <th scope="row">1</th>
                                                                <td><input type="text" name="track[]" id="" class="form-control"></td>
                                                                <td><input type="text" name="artist[]" id="" class="form-control"></td>
                                                                <td></td>
                                                            </tr> 
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
    
                                            </div>
                                            <div class="row float-end me-5 ">
                                                <div class="col me-4"><a href="" class="add_track"><i class="bi bi-plus-lg"></i></a></div>
                                            </div>
                                            <span class="invalid-feedback"><?= $data['tracklist_err'] ?></span>
                                        </div> 
                                        
                                        <div class="row  mt-5">
                                            <div class="col ms-4 ">
                                                <input type="submit" class="btn btn-success btn-block " value="Upload">
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>

                            </div>

                   

                    </div><!-- End blog posts list -->

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
            </section><!-- End Blog Section -->

        </main><!-- End #main -->

    <?php require APPROOT.'/views/inc/footer.php'; ?>
<?php require APPROOT.'/views/inc/bottom.php'; ?>