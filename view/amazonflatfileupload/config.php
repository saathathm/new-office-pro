<?php 

define('AWS_ACCESS_KEY_ID', 'AKIAJZN4G3CYMERWFAUQ');
define('AWS_SECRET_ACCESS_KEY', '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');
define('APPLICATION_NAME', 'PHP-App');
define('APPLICATION_VERSION', '1.0');
define('MERCHANT_ID', 'A3BBKV39A2BDVU');
define('MARKETPLACE_ID', 'ATVPDKIKX0DER');

function __autoload($className) {
    
    $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $includePaths = explode(PATH_SEPARATOR, get_include_path());
 
    foreach ($includePaths as $includePath) {
       $includePath . DIRECTORY_SEPARATOR . $filePath;
        if (file_exists($includePath . DIRECTORY_SEPARATOR . $filePath)) {
         
            require_once $filePath;
           
            return;
        }
    }
}

?>
