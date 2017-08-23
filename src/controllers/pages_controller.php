<?php
  class PagesController {
    public function login() {
      require_once('views/pages/login.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }

  }
?>