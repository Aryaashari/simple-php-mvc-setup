<?php

namespace Ewallet\App;

use Ewallet\Config\App;

class View {

    public static function render(string $pathToView, array $data = []) {
        require_once __DIR__."/../view/$pathToView";
    }

    public static function redirect(string $path) {
        $baseUrl = App::$baseUrl;
        $url = $baseUrl.$path;
        header("location: $url");
        exit();
    }

}