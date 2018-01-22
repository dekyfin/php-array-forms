<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload


$f = new DF\ArrayForm( ["a"=>3] );

$f->dumpData();

