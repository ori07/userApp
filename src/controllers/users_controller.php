<?php
  class UsersController {
    public function index() {
      // we store all the posts in a variable
      $posts = Users::all();
      require_once('views/users/index.php');
    }

    public function show() {
      // we expect a url of form ?controller=posts&action=show&user_name=x&user_password=y

      //verify is the user's input is valid

      
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $post = Post::find($_GET['id']);
      require_once('views/posts/show.php');
    }

    public function error_unauthorized() {
      require_once('views/pages/error_unauthorized.php');
    }

    public function error_user() {
      require_once('views/pages/error_user.php');
    }
  }
?>