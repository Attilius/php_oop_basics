<?php

declare(strict_types = 1);
session_start();
error_reporting(E_ALL);
ini_set("display_errors", "1");

require_once "../core/functions.php";
require_once "../vendor/autoload.php";

(new Application(new ServiceContainer(include "../services.php")))->start(realpath(__DIR__."/../")); // class member access on instantiation since php 5.4
