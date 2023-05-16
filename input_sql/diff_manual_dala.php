<?php
	#Include the connect.php file
	include('connect.php');
	
	#Connect to the database
	//connection String

	$connect = mysql_connect($hostname, $username, $password)
							or die('Could not connect: ' . mysql_error());
	
	//Select The database
	$bool = mysql_select_db($database, $connect);
	if ($bool === False){
	   print "Can't find $database!";
	}
	
	// get data and store in a json array
	$method = $_POST['method'];
	// echo "342342332432";
	
	switch($method)
	{
	case "getsimilar":
		// pop from the manual_check table and insert into contacts table
		if(isset($_POST['id']))
		{
			// add function levenshtein if doesn't exist
			$query = "SHOW FUNCTION STATUS like 'levenshtein'";
			$result = mysql_query($query) or die("Mysql error:" . mysql_error());
			$rows = mysql_fetch_array($result);
			if(count($rows['Name']) == 0) 
				// the function doesn't exists
			{	
				$query = "CREATE FUNCTION levenshtein( s1 VARCHAR(255), s2 VARCHAR(255) ) \n"
							. 			  "RETURNS INT \n"
							. 			  "DETERMINISTIC \n"
							. 			  "BEGIN \n"
							. 				"DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT; \n"
							. 				"DECLARE s1_char CHAR; \n"
							. 				"-- max strlen=255 \n"
							. 				"DECLARE cv0, cv1 VARBINARY(256); \n"
							. 				"SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0; \n"
							. 				"IF s1 = s2 THEN \n"
							. 				"  RETURN 0; \n"
							. 				"ELSEIF s1_len = 0 THEN \n"
							. 				  "RETURN s2_len; \n"
							. 				"ELSEIF s2_len = 0 THEN \n"
							. 				  "RETURN s1_len; \n"
							. 				"ELSE \n"
							. 				  "WHILE j <= s2_len DO \n"
							. 					"SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1; \n"
							. 				  "END WHILE; \n"
							. 				  "WHILE i <= s1_len DO \n"
							. 					"SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1; \n"
							. 					"WHILE j <= s2_len DO \n"
							. 					  "SET c = c + 1; \n"
							. 					  "IF s1_char = SUBSTRING(s2, j, 1) THEN  \n"
							. 						"SET cost = 0; ELSE SET cost = 1; \n"
							. 					  "END IF; \n"
							. 					  "SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost; \n"
							. 					  "IF c > c_temp THEN SET c = c_temp; END IF; \n"
							. 						"SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1; \n"
							. 						"IF c > c_temp THEN  \n"
							. 						  "SET c = c_temp;  \n"
							. 						"END IF; \n"
							. 						"SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1; \n"
							. 					"END WHILE; \n"
							. 					"SET cv1 = cv0, i = i + 1; \n"
							. 				  "END WHILE; \n"
							. 				"END IF; \n"
							. 			  "	RETURN c; \n"
							. 			  "END";
				mysql_query($query) or die("Mysql error:" . mysql_error());
			}
		
			// get item from the manual_check table
			$id = $_POST['id'];
			$query = "SELECT * FROM manual_check WHERE id = $id";
			$result = mysql_query($query) or die("SQL SELECT with id: ". mysql_error());
			$rows = mysql_fetch_assoc($result);
			
			// select similars records from the contacts table.
			$sql = "SELECT * , (levenshtein(name, '".$rows['name']."') + levenshtein(surname, '".$rows['surname']."') + "
					."levenshtein(address, '".$rows['address']."') + levenshtein(phone, '".$rows['phone']."')) as diff ";
			$sql .= "FROM contacts ";
			$sql .= "ORDER BY diff ";
			$sql .= "LIMIT 10";

			$result = mysql_query($sql) or die("SQL INSERT into contacts: ". mysql_error());
			
			$total_rows = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$persons[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'surname' => $row['surname'],
					'address' => $row['address'],
					'suburb' => $row['suburb'],
					'state' => $row['state'],
					'zip' => $row['zip'],
					'phone' => $row['phone'],
					'alt_phone' => $row['alt_phone'],
					'alt_phone2' => $row['alt_phone2'],
					);
				$total_rows++;
			}
	
			$data[] = array(
				 'TotalRows' => $total_rows,
				 'Rows' => $persons
			);
			
			echo json_encode($data);
		}
		break;
	case "totalrows":
		$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
		$rows = mysql_query($sql);
		$rows = mysql_fetch_assoc($rows);
		$total_rows = $rows['found_rows'];
		break;
		
	case "acceptrow":
		// pop from the manual_check table and insert into contacts table
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
			$query = "SELECT * FROM manual_check WHERE id = $id";
			$result = mysql_query($query) or die("SQL SELECT with id: ". mysql_error());
			$rows = mysql_fetch_assoc($result);
			
			$sql = "INSERT INTO contacts ";
			$sql .= "(name, surname, address, suburb, state, zip, phone, alt_phone, alt_phone2, business_name, business_address, business_zip, last_update, classification, comments) ";
			$sql .= "VALUES ";
			$sql .= "('".$rows['name']."', '".$rows['surname']."', '".$rows['address']."', '".$rows['suburb']."', '".$rows['state'].
					"', '".$rows['zip']."', '".$rows['phone']."', '".$rows['alt_phone']."', '".$rows['alt_phone2']."', NULL, NULL, NULL, '0000-00-00 00:00:00', 'NONE', NULL);";
			
			mysql_query($sql) or die("SQL INSERT into contacts: ". mysql_error());
			
			$sql = "DELETE FROM manual_check where id=$id";
			mysql_query($sql) or die("SQL DELETE error: ".mysql_error());
			$data[] = array(
				"result" => "success"
			);
			echo json_encode($data);
		}
		break;
	case "rejectrow":
		// pop from the manual_check table and insert into dups table
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
			$query = "SELECT * FROM manual_check WHERE id = $id";
			$result = mysql_query($query) or die("SQL SELECT with id: ". mysql_error());
			$rows = mysql_fetch_assoc($result);
			
			$sql = "INSERT INTO dups ";
			$sql .= "(name, surname, address, suburb, state, zip, phone, alt_phone, alt_phone2, business_name, business_address, business_zip, last_update, classification, comments) ";
			$sql .= "VALUES ";
			$sql .= "('".$rows['name']."', '".$rows['surname']."', '".$rows['address']."', '".$rows['suburb']."', '".$rows['state'].
					"', '".$rows['zip']."', '".$rows['phone']."', '".$rows['alt_phone']."', '".$rows['alt_phone2']."', NULL, NULL, NULL, '0000-00-00 00:00:00', 'NONE', NULL);";
			
			mysql_query($sql) or die("SQL INSERT into contacts: ". mysql_error());
			
			$sql = "DELETE FROM manual_check where id=$id";
			mysql_query($sql) or die("SQL DELETE error: ".mysql_error());
			$data[] = array(
				"result" => "success"
			);
			echo json_encode($data);
		}
		break;
	case "deleterow":
		// pop from the manual_check
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
			$sql = "DELETE FROM manual_check where id=$id";
			mysql_query($sql) or die("SQL DELETE error: ".mysql_error());
			$data[] = array(
				"result" => "success"
			);
			echo json_encode($data);
		}
		break;
	case "getdata":
		if(isset($_POST['start']) && isset($_POST['count']))
		{
			$start = $_POST['start'];
			$count = $_POST['count'];
			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM manual_check LIMIT $start, $count";
			
			$result = mysql_query($query) or die("SQL Error SELECT: ".mysql_error());
			$sql = "SELECT FOUND_ROWS() AS 'found_rows';";
			$rows = mysql_query($sql);
			$rows = mysql_fetch_assoc($rows);
			$total_rows = $rows['found_rows'];

			$persons = null;
			
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$persons[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'surname' => $row['surname'],
					'address' => $row['address'],
					'suburb' => $row['suburb'],
					'state' => $row['state'],
					'zip' => $row['zip'],
					'phone' => $row['phone'],
					'alt_phone' => $row['alt_phone'],
					'alt_phone2' => $row['alt_phone2'],
				);
			}
			
			$data[] = array(
				 'TotalRows' => $total_rows,
				 'Rows' => $persons
			);
			
			echo json_encode($data);
		}
		break;
	}
?>