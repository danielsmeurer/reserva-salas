<?php ini_set('display_errors', 'On');
require_once('config.php');
/*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php');

    /*** class Loader ***/
    function classLoader($class)
    {
       
        $filename = strtolower($class);

        $file =FILES_BASE_ADDRESS.'/classes/' . $filename.'.php';
        if (!file_exists($file))
        {
          return false;
        }
        require_once $file;
    }
    
	spl_autoload_register('classLoader');

   