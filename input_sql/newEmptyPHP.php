<?php
include_once 'AppManager.php';
$pm = AppManager::getPM();
$query1 = "select * from dups";
$query = "SHOW FUNCTION STATUS like 'levenshtein'";
  $result = $pm->num_row($query1);
            //$result = mysql_query($query) or die("Mysql error:" . mysql_error());
            echo count($result);
            if (mysql_num_rows($result) == 0) {
                // the function doesn't exists
                 $query = "CREATE FUNCTION levenshtein( s1 VARCHAR(255), s2 VARCHAR(255) ) \n"
                        . "RETURNS INT \n"
                        . "DETERMINISTIC \n"
                        . "BEGIN \n"
                        . "DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT; \n"
                        . "DECLARE s1_char CHAR; \n"
                        . "-- max strlen=255 \n"
                        . "DECLARE cv0, cv1 VARBINARY(256); \n"
                        . "SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0; \n"
                        . "IF s1 = s2 THEN \n"
                        . "  RETURN 0; \n"
                        . "ELSEIF s1_len = 0 THEN \n"
                        . "RETURN s2_len; \n"
                        . "ELSEIF s2_len = 0 THEN \n"
                        . "RETURN s1_len; \n"
                        . "ELSE \n"
                        . "WHILE j <= s2_len DO \n"
                        . "SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1; \n"
                        . "END WHILE; \n"
                        . "WHILE i <= s1_len DO \n"
                        . "SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1; \n"
                        . "WHILE j <= s2_len DO \n"
                        . "SET c = c + 1; \n"
                        . "IF s1_char = SUBSTRING(s2, j, 1) THEN  \n"
                        . "SET cost = 0; ELSE SET cost = 1; \n"
                        . "END IF; \n"
                        . "SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost; \n"
                        . "IF c > c_temp THEN SET c = c_temp; END IF; \n"
                        . "SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1; \n"
                        . "IF c > c_temp THEN  \n"
                        . "SET c = c_temp;  \n"
                        . "END IF; \n"
                        . "SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1; \n"
                        . "END WHILE; \n"
                        . "SET cv1 = cv0, i = i + 1; \n"
                        . "END WHILE; \n"
                        . "END IF; \n"
                        . "	RETURN c; \n"
                        . "END";
                mysql_query($query) or die("Mysql error:" . mysql_error());
            }
?>
