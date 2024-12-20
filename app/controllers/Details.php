<?php 
class Details extends Controller{

    private $userModel;
    private $postModel;
    private $commentModel;
    private $genreModel;
    private $profileModel;
    private $recentPosts;
    private $categories;
    private $postCount;

    public function __construct(){
        $this->userModel = $this->model('User');
        $this->profileModel = $this->model('Profile');
        $this->postModel = $this->model('Post');
        $this->commentModel = $this->model('Comment');
        $this->genreModel = $this->model('genre');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;

    }

    public function index($title = null, $id = null){

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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $data = [
                'comments' => $comments,
                'post' => $post,
                'genre' => $genre,
                'user' => $user,
                'profile' => $profile,
                'post_count' => $post_count,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
                'name' => ucwords(trim($_POST['name'])),
                'posts_id' => $id,
                'email' => trim($_POST['email']),
                'content' => trim($_POST['comment']),
                'website' => trim($_POST['website']),
                'token' => trim($_POST['csrf_token']),
                'name_err' => '',
                'email_err' => '',
                'comment_err' => '',
                'website_err' => '',
            ];

             Csrf::check($data['token']);

            if(Logged::in()){
                $user = $this->userModel->findUserById(Session::get('id'));
                $profile = $this->profileModel->getProfileByUserId(Session::get('id'));

                $data['users_id'] = $user->id;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['website'] = $profile->web;

                if(empty($data['content'])){
                    $data['comment_err'] = 'Please enter valid Comment';
                }

            }else{
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter a valid name';
                }
                if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['email_err'] = 'Please enter a valid email';
                }
                if(empty($data['content'])){
                    $data['comment_err'] = 'Please enter valid Comment';
                }
                
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['website_err']) && empty($data['comment_err'])){

                if ($this->commentModel->createComment($data)) {
                    Session::set('comment_success', 'Comment Added Successfull.');
                    Redirect::to('details', $title, $id);

                }else{
                    Redirect::to('404');
                }

            }else{
                Session::set('comment_failed', 'Comment Failed to update.');
                $this->view('details', $data);
            }
        }else{
       
            $data = [
                'comments' => $comments,
                'post' => $post,
                'genre' => $genre,
                'user' => $user,
                'profile' => $profile,
                'post_count' => $post_count,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
                'name'=> '',
                'email'=> '',
                'website'=> '',
                'content'=> '',
                'name_err'=> '',
                'email_err'=> '',
                'website_err'=> '',
                'comment_err'=> ''
            ];
            $this->view('details', $data);
        }
    }
    
}