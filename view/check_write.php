<?php
echo "check write";

$myFile = "testFile.txt";
                                        $fh = fopen($myFile, 'w') or die("can't open file");
                                        fwrite($fh, "wwww");
                                        fclose($fh);


?>