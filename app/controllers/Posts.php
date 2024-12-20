<?php

class Posts extends Controller{

    private $userModel;
    private $postModel;
    private $commentModel;
    private $genreModel;
    private $profileModel;
    private $recentPosts;
    private $categories;
    private $postCount;
    private $user;
    private $allGenres;

    public function __construct(){
        Logged::inRedirect();

        $this->userModel = $this->model('User');
        $this->user = $this->userModel->findUserById(Session::get('id'));
        $this->profileModel = $this->model('Profile');
        $this->postModel = $this->model('Post');
        $this->commentModel = $this->model('Comment');
        $this->genreModel = $this->model('genre');
        $this->allGenres = $this->genreModel->getAllGenre();
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;

    }


    public function index($page = 1){

        $posts = $this->postModel->getUserPostsAndRelations($this->user->id, $page);
        $data = [
            'user' => $this->user, 
            'posts' => $posts,
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];

        $this->view('posts/index', $data);

    }


    public function add(){
        $genres = $this->genreModel->getAllGenre();

        

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Csrf::check($_POST['csrf_token']);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'mixpath' => '',
                'photopath' => '',
                'genre' => trim($_POST['genre']),
                'title_err' => '',
                'description_err' => '',
                'mixpath_err' => '',
                'photopath_err' => '',
                'genre_err' => '',
                'tracklist_err' => '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
                
            ];

            if(!empty($_POST['track'])){
                $tracklist = array();
                $tracks = $_POST['track'];
                $artists = $_POST['artist'];
                $no = 1;
                foreach($tracks as $key=>$value){
                    if(!empty($tracks[$key]) || !empty($artists[$key])){
                        $track = array();
                        $track['no'] = $no;
                        $track['artist'] = $artists[$key] ;
                        $track['track'] = $value ;
    
                        array_push($tracklist, $track);
                        $no++;

                    }
                   
                }
            }

            if(empty($data['title'])){
                $data['title_err'] = 'Please enter a valid title';
            }elseif(preg_match('/[\'^£$%&*()}~`{@#~>?<>,|=_+¬-]/', $data['title']) || preg_match('[/]', $data['title'])){
                $data['title_err'] = 'Title cannot contain special characters';
            }elseif(!empty($this->postModel->getPostByIdOrTitle($data['title']))){
                $data['title_err'] = 'Title already exists. Kindly modify Title';
            }
            
            if(empty($data['description'])){
                $data['description_err'] = 'Please enter a valid Description';
            }
            if(empty($data['genre'])){
                $data['genre_err'] = 'Please select Genre';
            }else{
                $data['genre_value'] = '<option value="'.$data['genre'].'" selected>'.$this->genreModel->getGenreById($data['genre'])->title.'</option>';
            }
            if(!empty($tracklist[0]['artist'])){
                $data['tracklist_values'] = $tracklist;
            }
            if (empty($_FILES['mixpath']['name'])){
                $data['mixpath_err'] = 'Please Upload a Mixtape';
            }elseif(($_FILES['mixpath']['type'] != 'audio/mpeg') && ($_FILES['mixpath']['type'] != 'video/mp4')){
                $data['mixpath_err'] = 'Please Upload an MP3 or MP4 Mixtape (Music or Video)';
            }elseif($_FILES['mixpath']['size'] >= 100000000){
                $data['mixpath_err'] = 'Please Upload Mix  of 100MB or less';
            }

            // die($data['mixpath_err']);

            if ($_FILES['photopath']['name']){

                if ($_FILES['photopath']['type'] != 'image/jpeg') {
                    $data['photopath_err'] = 'Please Upload only JPEG Photo';
                }
                if($_FILES['photopath']['size'] >= 5000000){
                    $data['photopath_err'] = 'Please Upload JPEG image of 5MB or less';
                }
               
            }

            if(empty($data['title_err']) && empty($data['description_err']) && empty($data['mixpath_err']) && empty($data['photopath_err']) && empty($data['genre_err']) && empty($data['tracklist_err'])){

                if ($_FILES['photopath']['name']) {		

                    $cover_name 		= $_FILES['photopath']['name'];
                    $cover_size			= $_FILES['photopath']['size'];
                    $cover_type 		= $_FILES['photopath']['type'];
                    $cover_tmp_name		= $_FILES['photopath']['tmp_name'];
                    $cover_name_tag		= md5($cover_tmp_name.random_bytes(10));
                    $new_cover_name		= 'cover_'.$cover_name_tag.'.jpg';
                    $cover_location          = APPMEDIA.'covers';
        
                    if (!file_exists($cover_location)) {
                        mkdir($cover_location, 0777, true);
                    }
                    move_uploaded_file($cover_tmp_name, $cover_location.'/'.$new_cover_name);
                }else{
                    $new_cover_name = 'default.jpg'; 
                }

                $mix_name 		= $_FILES['mixpath']['name'];
                $mix_size		= $_FILES['mixpath']['size'];
                $mix_type 		= $_FILES['mixpath']['type'];
                $mix_tmp_name	= $_FILES['mixpath']['tmp_name'];
                $mix_name_tag	= md5($mix_tmp_name.random_bytes(10));

                if($mix_type == 'video/mp4'){
                    $new_mix_name		= 'video_'.$mix_name_tag.'.mp4';
                    $mix_location     = APPMEDIA.'videos';
                }elseif($mix_type == 'audio/mpeg'){
                    $new_mix_name		= 'audio_'.$mix_name_tag.'.mp3';
                    $mix_location     = APPMEDIA.'audios';
                }


              
                if (!file_exists($mix_location)) {
                    mkdir($mix_location, 0777, true);
                }
                move_uploaded_file($mix_tmp_name, $mix_location.'/'.$new_mix_name);

                $data = [
                    'user_id' => Session::get('id'),
                    'title' => trim($_POST['title']),
                    'description' => trim($_POST['description']),
                    'cover_name' => $new_cover_name,
                    'mix_name' => $new_mix_name,
                    'mix_type' => $mix_type,
                    'genre_id' => trim($_POST['genre']),
                    'tracklist' => json_encode($tracklist)
                ];
              
                if ($this->postModel->createPost($data)) {
                    Session::set('createpost_success', '<strong>Post Created Successfully.</strong>');
                    Redirect::to('details', $data['title'], $this->postModel->getPostByIdOrTitle($data['title'])->id);
                }else{
                    die('something went wrong');
                }
            }else{
                $data['genres'] = $genres;
                Session::set('upload_failed', '<strong>Upload Failed</strong> Kindly fill the form correctly.');
                $this->view('posts/add', $data);
            }
        } else{
            $data = [
                'title' => '',
                'description' => '',
                'mixpath' => '',
                'photopath' => '',
                'genres' => $this->allGenres,
                'tracklist' => '',
                'title_err' => '',
                'description_err' => '',
                'mixpath_err' => '',
                'photopath_err' => '',
                'genre_err' => '',
                'tracklist_err' => '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
            ];
            $this->view('posts/add', $data);
        }
    }

    public function details($title = null, $id = null){

        if(empty($title) && empty($id) ){
            Redirect::to('404');
        }


        $id = !empty($id) ? (int)$id : null;
        $title = str_replace('-',' ', $title);      
        $post = $this->postModel->getPostByIdOrTitle($title);
        $post_id = (int)$post->id;
        $comments = $this->commentModel->getCommentsByPostId($post_id);
        $genre = $this->genreModel->getGenreById($post->genre_id);
        $profile = $this->profileModel->getProfileByUserId($post->user_id);
        $user = $this->userModel->findUserById($post->user_id);
        $post_count = $this->postModel->getUserPostsCount($post->user_id);
        $post->tracklist = json_decode($post->tracklist);
     
        $data = [
            'comments' => $comments,
            'post' => $post,
            'genre' => $genre,
            'user' => $user,
            'profile' => $profile,
            'post_count' => $post_count,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];
        $this->view('posts/details', $data);
    }


    public function edit($title = null, $id = null ){
        $title = str_replace('-',' ', $title);      
        $id = !empty($id) ? (int)$id : null;
        $post = $this->postModel->getPostByIdOrTitle($title);
        if((empty($title) && empty($id)) || (empty($post))){
            Redirect::to('404');
        }

        $data = [
            'post' => $post,
            'title' => $post->title,
            'description' => $post->description,
            'mixpath' => $post->mix_name,
            'mix_type' => $post->mix_type,
            'photopath' => $post->cover_name,
            'genres' => $this->allGenres,
            'genre_value' => '<option value="'.$post->genre_id.'" selected>'.$this->genreModel->getGenreById($post->genre_id)->title.'</option>',
            'tracklist_values' => json_decode($post->tracklist),
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];



        $this->view('posts/edit', $data);
    }


    public function delete($title = null, $id = null){
        $title = str_replace('-', ' ', $title);
        $post = $this->postModel->getPostByIdOrTitle($title);
        if($this->postModel->deletePost($post->id)){
            Redirect::to('index');
        }else{
            Redirect::to('404');
        }
    }

    public function audios($page = 1){


        $data = [];
        $this->view('posts/audios', $data);
    }

    public function videos($page = 1){

        $data = [];
        $this->view('posts/videos', $data);
        
    }
}