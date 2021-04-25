<?php
session_start();

//Require all libraries
require_once 'libs/Core.php';
require_once 'libs/Controller.php';
require_once 'libs/Database.php';
require_once  'libs/Store.php';

//Require configurations
require_once 'config/config.php';

//Create Core Object
$init = new Core();