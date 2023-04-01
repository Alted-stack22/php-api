<?php

$time = time();
echo "Time: $time".PHP_EOL."Hash: ".sha1($argv[1].$time.'01234567').PHP_EOL;
