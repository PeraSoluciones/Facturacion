<?php

namespace Facturacion\Helper;

class Autoloader
{
    public function registrar()
    {

        spl_autoload_register(function ($class) {

            // project-specific namespace prefixes
            $prefixes = array(
                'Facturacion\\Modelo\\',
                'Facturacion\\Controlador\\',
                'Facturacion\\Vista\\',
                'Facturacion\\Helper\\'
            );

            $hasPrefix = false;
            $baseDir = 'Facturacion/';

            foreach ($prefixes as $prefix) {
                // does the class use the namespace prefix?
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) === 0) {
                    // no, move to the next registered autoloader
                    // return;
                    $hasPrefix = true;
                    break;
                }
            }

            if (!$hasPrefix) {
                return;
            }

            // get the relative class name
            // $relative_class = substr($class, $len - strlen($baseDir), strlen($class));
            $relative_class = substr_replace($class, '', 0, strlen($baseDir));


            // replace the namespace prefix with the base directory, replace namespace
            // separators with directory separators in the relative class name, append
            // with .php
            $file = '../' . str_replace('\\', '/', $relative_class) . '.php';

            // if the file exists, require it
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}
