<?php

class HomeController extends Controller {

    function dashboard()
    {
        echo Template::instance()->render('../views/home/header.html');
        echo Template::instance()->render('../views/home/dashboard.html');
        echo Template::instance()->render('../views/home/footer.html');
        die;
    }


}