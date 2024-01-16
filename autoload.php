<?php

spl_autoload_register('classAutoLoader');

function classAutoLoader($class){
    $path = 'Model/'.$class.'.php';
    $path2 = 'Controller/'.$class.'.php';

    if (file_exists($path)) {
        require_once $path;
    }
    
    if (file_exists($path2)) {
        require_once $path2;
    }
 
}