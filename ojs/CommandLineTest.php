<?php

$output = shell_exec("ls");
echo $output;
echo "\n";

$goStatus = shell_exec("go");
echo $goStatus;
?>