<?php

class Controller {

    protected $f3;
    protected $db;

    function beforeroute()
    {
        $pathURI = explode('/', substr($this->f3['PATH'], 1));

        if( !$pathURI[0] ){
            $this->f3->reroute('/index');
            die;
        }

        //check login
        if( !$this->f3->get('SESSION.email') || $this->f3->get('SESSION.expiry') < time() ) {
            if( $pathURI[0] !== "login" && $pathURI[0] !== "index" ){
                $this->f3->set('SESSION.pre_path', $this->f3['PATH']);
                $this->f3->reroute('/login');
                die;
            }
        }

        //set common template
        $this->f3->set('nav_left','../views/common/nav_left.html');
        $this->f3->set('nav_top','../views/common/nav_top.html');

    }

    function __construct()
    {
        $f3=Base::instance();

        $db=new DB\SQL(
            $f3->get('db_dns') . $f3->get('db_name'),
            $f3->get('db_user'),
            $f3->get('db_pass')
        );

        $this->f3=$f3;
        $this->db=$db;
    }


}