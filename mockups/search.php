<?php

$dbhost = "localhost";
$dbuser = "nova";
$dbpass = "";
$dbname = "nova3_install";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$query = (isset($_GET['query'])) ? $_GET['query'] : null;
$type = (isset($_GET['type'])) ? $_GET['type'] : 'count';

switch ($type)
{
	case 'count':
	default:
		$sql = mysql_query("SELECT count(url_id) 
									FROM urls 
									WHERE MATCH(url_url, url_title, url_desc)
									AGAINST('$query' IN BOOLEAN MODE)");
		$total = mysql_fetch_array($sql);
		$num = $total[0];
		
		echo $num;
	break;
	
	case 'results':
		if ( ! empty($query))
		{
			$only_search_email = (bool) preg_match('(@)', $query);
			
			$email = "SELECT name, email FROM nova_users WHERE email LIKE '%$query%'";
			$emailR = mysql_query($email);
			$emailA = array();
			
			while ($row = mysql_fetch_array($emailR))
			{
				$emailA[] = $row;
			}
			
			if (count($emailA) > 0)
			{
				foreach ($emailA as $key => $value)
				{
					$retval['email'][] = array(
						'name' => $value[0],
						'email' => $value[1]
					);
				}
			}
			
			if ( ! $only_search_email)
			{
				$name = "SELECT name, email FROM nova_users WHERE name LIKE '%$query%'";
				$nameR = mysql_query($name);
				$nameA = array();
				
				while ($row = mysql_fetch_array($nameR))
				{
					$nameA[] = $row;
				}
				
				
				
				if (count($nameA) > 0)
				{
					foreach ($nameA as $key => $value)
					{
						$retval['name'][] = array(
							'name' => $value[0],
							'email' => $value[1]
						);
					}
				}
				
				$chars = "SELECT a.id, a.name, a.email, b.first_name, b.last_name FROM nova_users AS a, nova_characters AS b ";
				$chars.= "WHERE (b.first_name LIKE '%$query%' OR b.last_name LIKE '%$query%') AND a.id = b.user_id";
				$charsR = mysql_query($chars);
				$charsA = array();
				
				while ($row = mysql_fetch_array($charsR))
				{
					$charsA[] = $row;
				}
				
				if (count($charsA) > 0)
				{
					foreach ($charsA as $key => $value)
					{
						$retval['characters'][] = array(
							'userid'	=> $value[0],
							'name'		=> $value[1],
							'email' 	=> $value[2],
							'fname'		=> $value[3],
							'lname'		=> $value[4],
						);
					}
				}
			}
		}
		else
		{
			$retval = array();
		}
		
		echo json_encode($retval);
	break;
}

mysql_close($conn);
