<head>

  <meta charset="utf-8" />
  <title>Satellitefinder DB-Test</title>
</head>
<body>
<?php
	function openDB()
	{
		$db_server = 'localhost';
		$db_name = 'satfinder';
		$db_user = 'root';
		$db_passwort = '';
      
    	$db = @ mysql_connect ($db_server, $db_user, $db_passwort);
    	$db_select = @ mysql_select_db($db_name);
		
		return($db);
	}

	function getAllSatellites()
	{
		$sql = 'SELECT * FROM satellites';
    	$result = mysql_query($sql);
	
		$satellites = array();
		$i = 0; 
	
		while($row = mysql_fetch_row($result))
		{
			if($i == 0)
			{
				for($j = 0; $j < count($row); $j++)
				{
					$satellites[$i][$j] = mysql_field_name($result, $j);
				}
				$i++;
				$satellites[$i] = $row;
				$i++;
			}
			else
			{
				$satellites[$i] = $row;
				$i++;  
			}
		}
		return($satellites);
	}
	
	function getModesBySatellite($satId)
	{
		$sql = 'SELECT * FROM modes WHERE sat_ID ='.$satId;
    	$result = mysql_query($sql);
	
		$modes = array();
		$i = 0; 
	
		while($row = mysql_fetch_row($result))
		{
			if($i == 0)
			{
				for($j = 0; $j < count($row); $j++)
				{
					$modes[$i][$j] = mysql_field_name($result, $j);
				}
				$i++;
				$modes[$i] = $row;
				$i++;
			}
			else
			{
				$modes[$i] = $row;
				$i++;  
			}
		}
		return($modes);
	}
	
	function getPolarByMode($modeId)
	{
		$sql = 'SELECT * FROM mode_polar WHERE mode_ID ='.$modeId;
        $result = mysql_query($sql);
		
		$check = false;
		$polarId = '';
		
		while($row = mysql_fetch_row($result))
		{
			if($check == false)
			{
				$polarId = $row[2];
				$check = true;
			}
			else
			{
				$polarId = $polarId.' OR polar_ID ='.$row[2];
				$check = true;
			}
		}
		
		$polar = array();
		
		if($polarId != '' && $polarId != null)
		{
			$sql = 'SELECT * FROM polar WHERE polar_ID ='.$polarId;
			$result = mysql_query($sql);
		
			$i = 0;
		
			while($row = mysql_fetch_row($result))
			{
				if($i == 0)
				{
					for($j = 0; $j < count($row); $j++)
					{
						$polar[$i][$j] = mysql_field_name($result, $j);
					}
					$i++;
					$polar[$i] = $row;
					$i++;
				}
				else
				{
					$polar[$i] = $row;
					$i++;  
				}
			}
		}
		return($polar);
	}
	
	function getGeometry($geometryId)
	{
		$sql = 'SELECT * FROM geometry WHERE geometry_ID ='.$geometryId;
    	$result = mysql_query($sql);
	
		$geometry = array();
		$i = 0; 
	
		while($row = mysql_fetch_row($result))
		{
			if($i == 0)
			{
				for($j = 0; $j < count($row); $j++)
				{
					$geometry[$i][$j] = mysql_field_name($result, $j);
				}
				$i++;
				$geometry[$i] = $row;
				$i++;
			}
			else
			{
				$geometry[$i] = $row;
				$i++;  
			}
		}
		return($geometry);
	}
	
	function getDatacontentByDatatype($datacontentId)
	{
		$sql = 'SELECT * FROM datacontent WHERE datacontent_ID ='.$datacontentId;
    	$result = mysql_query($sql);
	
		$datacontent = array();
		$i = 0; 
	
		while($row = mysql_fetch_row($result))
		{
			if($i == 0)
			{
				for($j = 0; $j < count($row); $j++)
				{
					$datacontent[$i][$j] = mysql_field_name($result, $j);
				}
				$i++;
				$datacontent[$i] = $row;
				$i++;
			}
			else
			{
				$datacontent[$i] = $row;
				$i++;  
			}
		}
		return($datacontent);
	}
	
	
	function getDatatypeByMode($modeId)
	{
		$sql = 'SELECT * FROM mode_datatype WHERE mode_ID ='.$modeId;
        $result = mysql_query($sql);
		
		$check = false;
		$datatypeId = '';
		
		while($row = mysql_fetch_row($result))
		{
			if($check == false)
			{
				$datatypeId = $row[2];
				$check = true;
			}
			else
			{
				$datatypeId = $datatypeId.' OR datatype_ID ='.$row[2];
				$check = true;
			}
		}
	    
		$datatype = array();
		
		if($datatypeId != '' && $datatypeId != null)
		{
			$sql = 'SELECT * FROM datatypes WHERE datatype_ID ='.$datatypeId;
			
			$result = mysql_query($sql);
		
			$i = 0;
		
			while($row = mysql_fetch_row($result))
			{				
				$geometry = getGeometry($row[1]);
				$datacontent = getDatacontentByDatatype($row[2]);
				$count = count($row)+2;
				
				if($i == 0)
				{
										
					for($j = 0; $j < $count; $j++)
					{
						if($j == $count-2)
							$datatype[$i][$j] = 'geometry';
						else if($j == $count-1)
							$datatype[$i][$j] = 'datacontent';
						else 
							$datatype[$i][$j] = mysql_field_name($result, $j);
					}
					$i++;
					$datatype[$i] = $row;
					$datatype[$i][$count-2] = $geometry[1][1];
					$datatype[$i][$count-1] = $datacontent[1][1];
					$i++;
				}
				else
				{
					$datatype[$i] = $row;
					$datatype[$i][$count-2] = $geometry[1][1];
					$datatype[$i][$count-1] = $datacontent[1][1];
					$i++;  
				}
			}
		}
		return($datatype);
	}

	$db = openDB();
	$satellites = getAllSatellites();
	
	echo'<table border = "1">';
	for($i = 0; $i < count($satellites); $i++)
	{
		echo'<tr>';
		for($j = 0; $j < count($satellites[$i]); $j++)
		{
			echo '<td>'.$satellites[$i][$j].'</td>';
		}
		if($satellites[$i][0] == 'sat_ID')
		{
			$modes = array();
			$modes[0][0] = 'modes';
		}
		else
		{
			$modes = array();
			$modes = getModesBySatellite($satellites[$i][0]);
		}
		echo '<td><table border = "1">';
		for($j = 0; $j < count($modes); $j++)
		{
			echo '<tr>';
			for($k = 0; $k < count($modes[$j]); $k++)
			{
				echo '<td>'.$modes[$j][$k].'</td>';
			}
			if($modes[$j][0] == 'mode_ID' || $satellites[$i][0] == 'sat_ID')
			{
				$polar = array();
				$polar[0][0] = 'polar';
			}
			else
			{
				$polar = array();
				$polar = getPolarByMode($modes[$j][0]);
			}
			echo '<td><table border = "1">';
			for($k = 0; $k < count($polar); $k++)
			{
				echo '<tr>';
				for($l = 0; $l < count($polar[$k]); $l++)
				{
					echo '<td>'.$polar[$k][$l].'</td>';
				}
				echo '</tr>';
			}
			echo '</table></td>';
			if($modes[$j][0] == 'mode_ID' || $satellites[$i][0] == 'sat_ID')
			{
				$datatype = array();
				$datatype[0][0] = 'datatype';
			}
			else
			{
				$datatype = array();
				$datatype = getDatatypeByMode($modes[$j][0]);
			}
			echo '<td><table border = "1">';
			for($k = 0; $k < count($datatype); $k++)
			{
				echo '<tr>';
				for($l = 0; $l < count($datatype[$k]); $l++)
				{
					echo '<td>'.$datatype[$k][$l].'</td>';
				}
				echo '</tr>';
			}
			echo '</table></td></tr>';
		}
		echo '</table></td></tr>';
	}
	echo '</table>';
	mysql_close($db);
?>