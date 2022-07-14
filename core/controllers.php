<?php

function homeController(){
    $size = $_GET['size'] ?? 10; // (??) if $_GET['size] = null -> default value = 10
    $page = $_GET['page'] ?? 1;
    $connection = getConnection();
    $total = getTotal($connection);
    $offset = ($page - 1) * $size;
    $content = getPhotosPaginated($connection, $size, $offset);
    $possiblePageSizes = [10,20,30,40,50];

    return [
        "home",
        [
            "title" => "Home",
            "content" => $content,
            "total" => $total,
            "size" => $size,
            "page" => $page,
            "offset" => $offset,
            "possiblePageSizes" => $possiblePageSizes
        ]
    ];
}

function aboutController(){
    echo "about";
}

function singleImageEditController($params){
    $title = $_POST["title"];
    $id = $params["id"];
    $connection = getConnection();
    updateImage($connection, $id, $title);
    return[
        "redirect:/php_oop_basics/image/$id",
        [
        ]
    ];
}

function singleImageDeleteController($params){
    $connection = getConnection();
    $id = $params["id"];

    deleteImage($connection, $id);
    return[
        "redirect:/php_oop_basics/",
        []
    ];
}

function singleImageController($params){
    $connection = getConnection();
    $image = getImageById($connection, $params['id']);

    return[
        "single",
        [
            "title" => $image->title,
            "image" => $image
        ]
    ];
}

function loginFormController(){
    $containsError = array_key_exists("containsError", $_SESSION);
    unset($_SESSION["containsError"]);
    return [
        "login",
        [
            "title" => "Login",
            "containsError" => $containsError
        ]
    ];
}

function loginSubmitController(){
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $user = loginUser(getConnection(), $email, $password);
    if ($user != null){
        $_SESSION["user"] = [
            "name" => $user["name"]
        ];
        $view = "redirect:/php_oop_basics/";
    }else{
        $_SESSION["containsError"] = 1;
        $view = "redirect:/php_oop_basics/login";
    }
    return [
        $view,
        []
    ];
}

function logoutSubmitController(){
    unset($_SESSION["user"]);
    return [
        "redirect:/php_oop_basics/",
        []
    ];
}

function notFoundController(){
    return [
        "404",
        [
            "title" => "The page you are looking for is not found."
        ]
    ];
}