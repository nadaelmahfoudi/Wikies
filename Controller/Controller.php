<?php

abstract class Controller{

    public function index(){

    }

    protected function view($view,$data = [])
    {
        extract($data);
        include "../View/$view.php";
    }

}