<?php

//llama dinamicamente a todas las clases siempre y cuando tengan el mismo nombre del archivo .php para php5
 spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});