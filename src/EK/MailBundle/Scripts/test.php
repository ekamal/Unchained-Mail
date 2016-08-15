<?php

$file = fopen("working.txt","a");
fwrite($file,"its working"."\n");
fclose($file);