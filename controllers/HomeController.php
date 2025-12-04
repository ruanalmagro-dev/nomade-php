<?php
class HomeController {
    public function index() {
        $model = new Property();
        $featured = $model->getAll();
        require 'views/home.php';
    }
}