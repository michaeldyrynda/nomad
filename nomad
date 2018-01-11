#!/usr/bin/env php
<?php

define('LARAVEL_START', microtime(true));

$app = require_once __DIR__.'/bootstrap/app.php';

$app->run();
