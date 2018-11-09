<?php
$conn=mysql_connect('localhost', 'sacvnnet', 'sY5C9n87ag', 'sacvnnet_group_1') or die("can't connect database");
 mysql_set_charset('UTF8',$conn);
  mysql_select_db('sacvnnet_group_1',$conn);
  $sql='
SELECT @curRank := @curRank +1 AS rank, member_id, member_name, member_point
FROM ranking p, (

SELECT @curRank :=0
)r
ORDER BY member_point DESC 
LIMIT 0 , 30';

	$retval = mysql_query( $sql, $conn );

If (! $retval )
{
die('Could not get data: ' . mysql_error());
}

$member_rank = array();
$member_id = array();
$member_name = array();
$member_point = array();
$i=0;
While ($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
array_push($member_rank,$row['rank']);
array_push($member_id,$row['member_id']);
array_push($member_name,$row['member_name']);
array_push($member_point,$row['member_point']);
echo $member_rank[$i]." ".$member_name[$i]." ".$member_point[$i];
$i++;
}

?>