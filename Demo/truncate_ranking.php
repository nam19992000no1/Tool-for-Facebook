<?php
header("Refresh:120");
date_default_timezone_set('asia/ho_chi_minh');


$link = mysqli_connect('localhost', 'sacvnnet', 'sY5C9n87ag', 'sacvnnet_group_1');
echo '-------------Bắt đầu Truncate Table--------------</br>';
for ($i=0;$i<1;$i++) {
$table[0] = "ranking";
$sql = "TRUNCATE TABLE {$table[$i]}";
$sql2 = "INSERT INTO ranking(member_id,member_name) SELECT member_id,member_name FROM members;";
if($link->query($sql))
{
	echo 'Truncate thành công dữ liệu bảng '.$table[$i]."</br>";
}
else
{
    echo 'Lỗi: ',mysqli_error($link);
}
if($link->query($sql2))
{
	echo 'Insert thành công dữ liệu bảng '.$table[$i]."</br>";
}
else
{
    echo 'Lỗi: ',mysqli_error($link);
}

}
echo '-------------Truncate thành công--------------</br>';
?>
