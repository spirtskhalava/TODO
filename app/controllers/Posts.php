<?php


class Posts extends Controller
{
   public function __construct()
   {
      // if(!isLoggedIn() ){
      //    redirect('users/login');
      // }

      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
   }

   public function index()
    {
       $posts = $this->postModel->getPosts();
       $data = [
          'posts' => $posts
       ];
       $this->view('posts/index', $data);
    }



    public function add()
    {
       if($_SERVER['REQUEST_METHOD']=='POST'){
          // Sanitize POST Array
          $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

          $data = [
             'title' => trim($_POST['title']),
             'body' => trim($_POST['body']),
             'user_id' => $_SESSION['user_id'],
             'status' => 'edited',
             'title_err' => '',
             'body_err' => ''
          ];

          // Validate
          if( empty($data['title']) ){
             $data['title_err'] = 'Please enter the title';
          }
          if( empty($data['body']) ){
             $data['body_err'] = 'Please enter the body';
          }

          // Make sure no errors
          if ( empty($data['title_err']) && empty($data['body_err']) ){
             // Validated
             if( $this->postModel->addPost($data) ){
                flash('post_message', 'Post Added');
                redirect('posts');
             } else{
                die('Something went wrong');
             }
          } else {
             // Load the view
             $this->view('posts/add', $data);
          }

       } else{
          $data = [
             'title' => '',
             'body' => ''
          ];
          $this->view('posts/add', $data);
       }

    }



   public function edit($id)
   {
      if($_SERVER['REQUEST_METHOD']=='POST'){
         // Sanitize POST Array
         $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

         $data = [
            'id' => $id,
            'title' => trim($_POST['title']),
            'body' => trim($_POST['body']),
            'user_id' => $_SESSION['user_id'],
            'title_err' => '',
            'body_err' => ''
         ];

         // Validate
         if( empty($data['title']) ){
            $data['title_err'] = 'Please enter the title';
         }
         if( empty($data['body']) ){
            $data['body_err'] = 'Please enter the body';
         }

         // Make sure no errors
         if ( empty($data['title_err']) && empty($data['body_err']) ){
            // Validated
            if( $this->postModel->updatePost($data) ){
               flash('post_message', 'Post Updated');
               redirect('posts');
            } else{
               die('Something went wrong');
            }
         } else {
            // Load the view
            $this->view('posts/edit', $data);
         }

      } else{
         // Get existing post from model
         $post = $this->postModel->getPostById($id);

         //Check for owner
         if( $post->user_id != $_SESSION['user_id'] ){
            redirect('posts');
         }
         $data = [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'title_err' => '',
            'body_err' => ''
         ];
         $this->view('posts/edit', $data);
      }

   }

   public function show($id)
   {
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);
      $data = [
         'post' => $post,
         'user' => $user
      ];
      $this->view('posts/show', $data);
   }


   public function delete($id)
   {
      if($_SERVER['REQUEST_METHOD']=='POST') {
         // Get existing post from model
         $post = $this->postModel->getPostById($id);

         //Check for owner
         if( $post->user_id != $_SESSION['user_id'] ){
            redirect('posts');
         }
         if( $this->postModel->deletePost($id) ){
            flash('post_message', 'Post removed');
            redirect('posts');
         } else {
            die('Something went wrong');
         }

      } else {
         redirect('posts');
      }
   }

public function sort()
   {
      if($_SERVER['REQUEST_METHOD']=='POST') {
         $orderposts = $this->postModel->OrderByUser();
         if($orderposts){
         $data = [
          'posts' => $orderposts
       ];
       $this->view('posts/index', $data);
         }else {
           // die('Something went wrong');
         }
   }
}

public function sortbyemail()
   {
      if($_SERVER['REQUEST_METHOD']=='POST') {
         $orderposts = $this->postModel->OrderByEmail();
         if($orderposts){
         $data = [
          'posts' => $orderposts
       ];
       $this->view('posts/index', $data);
         }else {
           // die('Something went wrong');
         }
   }
}
public function sortbyestatus()
   {
      if($_SERVER['REQUEST_METHOD']=='POST') {
         $orderposts = $this->postModel->OrderByStatus();
         if($orderposts){
         $data = [
          'posts' => $orderposts
       ];
       $this->view('posts/index', $data);
         }else {
           // die('Something went wrong');
         }
   }
}



}