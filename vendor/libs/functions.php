<?php

function debug($arr) {
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function upperCamelCase($name) {
    $name = str_replace('-', ' ', $name);
    $name = ucwords($name);
    $name = str_replace(' ', '', $name);
    
    return $name;
}

function lowerCamelCase($name) {
    $name = upperCamelCase($name);
    $name = lcfirst($name);
    
    return $name;
}