<?php


function autoload($class) {
    require 'data/db' . $class . '.php';
}



?>