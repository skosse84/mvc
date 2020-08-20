<?php

require_once 'autoload.php';
spl_autoload_register(['ClassLoader', 'autoload'], true, true);
Route::start();