<?php
namespace   wwwProject\userApp\public\app\Controllers;

    /**
    * Our base controller
    */
    class BaseController
    {
        protected $data;
        private $content;

        public function __construct(array $views)
        {
            $this->loadView($views);
        }

        /**
         * @return array data passed to the view
         */
        protected function getData(): array {
            return $this->data;
        }

        /**
         *  
         * @param  array  $views an array of views to be loaded
         * @return string the compiled view
         */
        protected function loadView(array $views) {
            ob_start();
                $data = $this->getData(); //data needed in the view
                foreach ($views as $k => $view) {
                    include $view;
                }
                $content = ob_get_contents();
            ob_end_clean();
            $this->content = $content;
        }

        /**
         * get's the buffer and returns it
         * @return string the buffer
         */
        public function out() : string {
            return $this->content;
        }
    }
?>