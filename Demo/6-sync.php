<?php
date_default_timezone_set('asia/ho_chi_minh');
require_once "config.php";
$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link,'UTF8');
$sql_users = 'SELECT oauth_uid,picture FROM users';
$sql_members = 'SELECT member_id,picture_sync FROM  members';
$image_link_users = array();
$image_link_members = array();
$retval = mysqli_query($link,$sql_users);
If (! $retval )
{
die('Could not get data: '. mysql_error());
}
$i=0;

While ($row = mysqli_fetch_array($retval, MYSQL_ASSOC))
{
array_push($image_link_users,$row['picture']);
$result_users = md5(substr($image_link_users[$i], 0, strpos($image_link_users[$i], "?")));
echo 'user_short: '.$result_users.'</br>';

$query="UPDATE users SET id_sync='".$result_users."' WHERE picture='".$image_link_users[$i]."'";
if($link->query($query))
{
    echo 'Cập nhật dữ liệu mới thành công </br>';
}
else
{
    echo '</br>Lỗi cập nhật: </br>'.mysqli_error($link).'</br>';
}
$i++;
}



$retval = mysqli_query($link,$sql_members);
If (! $retval )
{
die('Could not get data: '. mysql_error());
}
$i=0;
While ($row = mysqli_fetch_array($retval, MYSQL_ASSOC))
{
array_push($image_link_members,$row['picture_sync']);
$result_members = md5(substr($image_link_members[$i], 0, strpos($image_link_members[$i], "?")));
echo 'member_short: '.$result_members.'</br>';
$query="UPDATE members SET id_sync='".$result_members."' WHERE picture_sync='".$image_link_members[$i]."'";
if($link->query($query))
{
    echo 'Cập nhật dữ liệu mới thành công </br>';
}
else
{
    echo '</br>Lỗi cập nhật: </br>'.mysqli_error($link).'</br>';
}
$i++;
}







