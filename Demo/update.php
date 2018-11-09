<?php
date_default_timezone_set('asia/ho_chi_minh');

require "1-scanmember.php";
require "2-scanpost.php";
require "3-ranking.php";
require "4-memberpoint.php";
sleep(60);

echo '-------------Quét,nạp,tính ranking group thành công--------------</br>';
?>
