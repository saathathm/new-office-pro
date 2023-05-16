<?php

$file = fopen("error_check.txt", "a+");
           fwrite($file, "error_check");
            fclose($file);
            echo 'dfsdfsdf';
?>
