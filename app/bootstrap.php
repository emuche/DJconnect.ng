<?php

require_once 'config/config.php';


require_once 'helpers/Cookie.php';
require_once 'helpers/Logged.php';
require_once 'helpers/Session.php';
require_once 'helpers/Csrf.php';
require_once 'helpers/Redirect.php';
require_once 'helpers/Media.php';
require_once 'helpers/Format.php';


spl_autoload_register(function($className){
    require_once 'libraries/'.$className.'.php';
});

