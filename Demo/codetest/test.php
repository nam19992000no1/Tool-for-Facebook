 <?php
 $facebook_access_token='EAAAAAYsX7TsBALVQvcGupowcdUMcEvXuuiLC4ZCXvE3kx4WdFGEUoinDEARpXzTtzhn46HBkjQMY6VogfPesbsQmKCbYFg9YxYVrEsfBvLjrDupLvLvySYxpvq3ZCNWeAkOMcJ58ss4lCFGEP6cckGhZAnqZAyLfFSvC31mTA2K5MnYw1R0A6tBHp1EQPt1eKFFfaTJTYwZDZD';
 $conn=mysql_connect('localhost', 'sacvnnet', 'sY5C9n87ag', 'sacvnnet_group_1') or die("can't connect database");
 mysql_set_charset('UTF8',$conn);
  mysql_select_db('sacvnnet_group_1',$conn);
  
//----------------- Lấy bài viết hot 
  $sql='
SELECT post_id, post_type, post_created_time, member_id, member_name, post_reactions_count
FROM posts p
WHERE DATEDIFF( now( ) , post_created_time ) <=5 AND post_type= "photo" 
ORDER BY post_reactions_count DESC 
LIMIT 0 , 10';

	$retval = mysql_query( $sql, $conn );

If (! $retval )
{
die('Could not get data: ' . mysql_error());
}

$post_id = array();
$post_created_time = array();
$member_id = array();
$member_name = array();
$post_reactions_count = array();

$i=0;
While ($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
array_push($post_id,$row['post_id']);
array_push($post_created_time,$row['post_created_time']);
array_push($member_id,$row['member_id']);
array_push($member_name,$row['member_name']);
array_push($post_reactions_count,$row['post_reactions_count']);
$i++;
}

for($i=0;$i<=10;$i++){

echo '
<tr>
<td>'.$post_id[$i].'</td>
<td>'.$post_created_time[$i].'</td>
<td><a href="http://fb.com/'.$member_id[$i].'" target="_top" title="Trang cá nhân của '.$member_name[$i].'" rel="follow, index">'.$member_name[$i].'</a></td>
<td>'.$post_reactions_count[$i].'</td></br>

</tr>';
}

echo $post_id[0];
$url = 'https://graph.facebook.com/v2.8/'.$post_id[0].'?fields=from,full_picture&access_token=EAACEdEose0cBAHei2fYETB7lpBCBZBJxWZAH3cZBCZCw2ZB4uNWFam0oBE8gft4FIFx2I1vZAF1SiebvmSxmE7G31ZB6hHAPV082PSHihPeZBS134vAYuVHnvn6ftoxJt71PZAmI6zpK872T4MKwVtRZBnMSCG2zY5x40q12zzlxBhmzVOvMmFDdnd3ogtpiiAqOAZD';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$nameposter =  $obj->from->name; //Tra ra id
$time = date("h:i:s d/m/y"); // Tra ra Thoi gian hien tai
echo $nameposter;
?>