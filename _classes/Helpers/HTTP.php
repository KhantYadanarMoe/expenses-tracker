<?php

namespace Helpers;

class HTTP{
    static $base = "http://localhost/simple-expenses/project";

    static function redirect($path, $q = ""){
        $url = static::$base . $path; //static::$base = "https://localhost/fairway/project", $path = user_input page
        if($q) $url .= "?$q";

        header("Location: $url");
        exit();
    }
}