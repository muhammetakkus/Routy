<?php use View\Loader;

class Home extends Loader
{
    public function index(){
        $data['test'] = 'hello kitty';
        $this->view('main', $data);
        // echo 'home test loader'; 
    }
}