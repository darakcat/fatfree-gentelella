<?php

class LoginController extends Controller {

    function index()
    {
        $sess = new Session(NULL,'CSRF');
        $this->f3->csrf = $sess->csrf();
        $this->f3->copy('csrf','SESSION.csrf');

        $this->f3->set('csrf', $this->f3->csrf);

        echo Template::instance()->render('../views/login/login.html');
        die;
    }

    function auth() {
        if ($this->f3->get('POST.csrf') !== $this->f3->get('SESSION.csrf')) {
            echo "<script>alert('CSRF Error! Ask Administrator.');document.location='/login'</script>";
            die;
        } else {
            $email = $this->f3->get('POST.email');
            $password= $this->f3->get('POST.password');

            /* use ldap
            $login = new \Auth('ldap', array(
                    'dc' => 'ldaps://ldaps.com',
                    'rdn' => 'cn=gentelella,dc=gentelella,dc=com',
                    'base_dn'=> 'dc=gentelella,dc=com',
                    'pw' => 'gentelella')
            );

            $userInfo = $login->login($email, $password);
            */

            // use DB
            $user = new CRUD($this->db, 'users');
            $user_info = $user->getByParams(array('email' => $email));

            if( password_verify($password, $user_info[0]['password']) ){
                $this->f3->set('SESSION.user', $user_info[0]['user']);
                $this->f3->set('SESSION.email', $user_info[0]['email']);
                $this->f3->set('SESSION.expiry', time() + 3600);
                if($this->f3->get('SESSION.pre_path')){
                    $pre_path = $this->f3->get('SESSION.pre_path');
                    $this->f3->clear('SESSION.pre_path');
                    $this->f3->reroute($pre_path);
                } else {
                    $this->f3->reroute($this->f3->get('index_path'));
                }
            } else {
                echo "<script>alert('Check Your Password!');document.location='/login'</script>";
                die;
            }

        }
    }

    function register() {
        if ($this->f3->get('POST.csrf') != $this->f3->get('SESSION.csrf')) {
            echo "<script>alert('CSRF Error! Ask Administrator.');document.location='/login'</script>";
            die;
        } else {
            $this->f3->set('POST.password', password_hash($this->f3->get('POST.password'), PASSWORD_DEFAULT));
            $user = new CRUD($this->db, 'users');
            $user->add();

            $this->f3->reroute('/login');
        }
    }

    function logout() {
        $this->f3->clear('SESSION');
        $this->f3->clear('COOKIE');

        $this->f3->reroute('/login');
    }

}