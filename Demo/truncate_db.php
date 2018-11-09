

﻿<?php
header("Refresh:120");
date_default_timezone_set('asia/ho_chi_minh');


$link = mysqli_connect('localhost', 'sacvnnet', 'sY5C9n87ag', 'sacvnnet_group_1');
echo '-------------Bắt đầu Truncate Table--------------</br>';
for ($i=0;$i<=3;$i++) {

$table[0] = "comments";
$table[1] = "members";
$table[2] = "posts";
$table[3] = "reactions";

$sql = "TRUNCATE TABLE {$table[$i]}";


if($link->query($sql))
{
	
	echo 'Truncate thành công dữ liệu bảng '.$table[$i]."</br>";
	
}
else
{
    echo 'Lỗi: ',mysqli_error($link);
}

}
echo '-------------Truncate thành công--------------</br>';
?>
