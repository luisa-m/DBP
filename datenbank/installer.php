<?php

$file_content = file('_DATABASE_TWITTER_.sql');
$query = "";
foreach($file_content as $sql_line)
{
	if(trim($sql_line) != "" == false)
	{
 		$query = $sql_line;
 		if (substr(rtrim($query), -1) == ';')
 		{
   			echo $query;
   			$result = mysql_query($query)or exit(mysql_error(  ));
   			$query = "";
  		}
 	}
}

?>
