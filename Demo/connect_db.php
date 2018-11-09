<?php
//header("Refresh:120");
date_default_timezone_set('asia/ho_chi_minh');


$link = mysqli_connect('localhost', 'sacvnnet_community', 'T-k(WTZ%*t5@', 'sacvnnet_group_1');
 mysqli_set_charset($link,'UTF8');
  mysqli_select_db($link,'sacvnnet_group_1');
//nếu kết nối thất bại $link = NULL và sẽ báo lỗi
if (!$link) {
die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}
echo 'Kết nối thành công... '; 
?>