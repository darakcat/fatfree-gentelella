<?php

class IndexController extends Controller {

    function index()
    {
        $classes=array(
            'Base'=>
                array(
                    'hash',
                    'json',
                    'session',
                    'mbstring'
                ),
            'Cache'=>
                array(
                    'apc',
                    'memcache',
                    'memcached',
                    'redis',
                    'wincache',
                    'xcache'
                ),
            'DB\SQL'=>
                array(
                    'pdo',
                    'pdo_dblib',
                    'pdo_mssql',
                    'pdo_mysql',
                    'pdo_odbc',
                    'pdo_pgsql',
                    'pdo_sqlite',
                    'pdo_sqlsrv'
                ),
            'DB\Jig'=>
                array('json'),
            'DB\Mongo'=>
                array(
                    'json',
                    'mongo'
                ),
            'Auth'=>
                array('ldap','pdo'),
            'Bcrypt'=>
                array(
                    'mcrypt',
                    'openssl'
                ),
            'Image'=>
                array('gd'),
            'Lexicon'=>
                array('iconv'),
            'SMTP'=>
                array('openssl'),
            'Web'=>
                array('curl','openssl','simplexml'),
            'Web\Geo'=>
                array('geoip','json'),
            'Web\OpenID'=>
                array('json','simplexml'),
            'Web\Pingback'=>
                array('dom','xmlrpc')
        );

        $this->f3->set('classes',$classes);
        $this->f3->set('content','../views/index/welcome.htm');

        echo Template::instance()->render('../views/index/layout.htm');
        die;
    }

    function userref()
    {
        $this->f3->set('content','../views/index/userref.htm');
        echo Template::instance()->render('../views/index/layout.htm');
        die;
    }

}