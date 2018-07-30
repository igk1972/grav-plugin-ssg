<?php

if (getenv('BUILD') && !defined('GRAV_SETUP_PATH')) {
    define('GRAV_SETUP_PATH', __DIR__.DIRECTORY_SEPARATOR.'setup.php');
}
