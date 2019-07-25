<?php
    // SERVER/URL CONST
    define ('DOCUMENT_ROOT', dirname(dirname(dirname(__DIR__))));
    define ('APP_ROOT', dirname(dirname(__DIR__)));
    define ('URL_ROOT', 'http://php-rest-api-mvc.com');

    // DB Params
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'php-rest-api-mvc');
    define('DB_USER', 'test');
    define('DB_PASS', '123456');

    // JWT TOKEN SECRET
    define('TOKEN_SECRET', "ZP*R&G8'Z%eBO-/inVf*c$1sB`JBn#/[Y");
    define('TOKEN_EXP', 3600000); //ms 1h

?>