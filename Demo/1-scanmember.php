<?php
date_default_timezone_set('asia/ho_chi_minh');

require_once "config.php";
$dem=0;
for($i=0;$i<=50;$i++) {
if ($i > 0 and $dem < $i*200-1) {
break;
}
if ($i==0) {
$url = 'https://graph.facebook.com/v2.8/'.$idgroup.'/members?fields=name,first_name,last_name,middle_name,picture&limit=200&access_token='.$facebook_access_token; //Token đéo được sửa

}
else {
$linkAfter = $obj->paging->next;
$url = $linkAfter;
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
echo "<h2> link {$i} là {$url} </h2></br>";
for ($j=0;$j<=199;$j++) {
if (isset($obj->data[$j]->id)) {
$dem= $dem +1;
echo $dem." ".$obj->data[$j]->id." ".$obj->data[$j]->name." |  ";
//-------Update Database
$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link,'UTF8');
$prevQuery = 'SELECT member_id FROM members WHERE member_id ='.$obj->data[$j]->id;
if($link->query($prevQuery))
{
    echo 'Nhìn thấy dữ liệu liệu thành công |';
}
else
{
    echo '</br>Lỗi: </br>'.mysqli_error($link).'</br>';
}

$prevResult = $link->query($prevQuery);
if($prevResult->num_rows > 0){
	if(isset($obj->data[$j]->middle_name)){
$query = "UPDATE members SET member_id = '".$obj->data[$j]->id."',member_name = '".$obj->data[$j]->name."',member_first = '".$obj->data[$j]->first_name."',member_middle = '".$obj->data[$j]->middle_name."',member_last = '".$obj->data[$j]->last_name."',picture_sync='".$obj->data[$j]->picture->data->url."' WHERE member_id='".$obj->data[$j]->id."'";
} else {
	$query = "UPDATE members SET member_id = '".$obj->data[$j]->id."',member_name = '".$obj->data[$j]->name."',member_first = '".$obj->data[$j]->first_name."',member_last = '".$obj->data[$j]->last_name."',picture_sync='".$obj->data[$j]->picture->data->url."' WHERE member_id='".$obj->data[$j]->id."'";
}
if($link->query($query))
{
    echo ' Cập nhật dữ liệu thành công</br>';
}
else
{
    echo '</br>Lỗi: </br>'.mysqli_error($link).'</br>';
}
} else {
	if(isset($obj->data[$j]->middle_name)){
    $query = "INSERT INTO members (member_id,member_name,member_first,member_middle,member_last,picture_sync) values ('{$obj->data[$j]->id}',N'{$obj->data[$j]->name}',N'{$obj->data[$j]->first_name}',N'{$obj->data[$j]->middle_name}',N'{$obj->data[$j]->last_name}',N'{$obj->data[$j]->picture->data->url}');";
} else {
	$query = "INSERT INTO members (member_id,member_name,member_first,member_last,picture_sync) values ('{$obj->data[$j]->id}',N'{$obj->data[$j]->name}',N'{$obj->data[$j]->first_name}',N'{$obj->data[$j]->last_name}',N'{$obj->data[$j]->picture->data->url}');";
}
if($link->query($query))
{
    echo 'Thêm dữ liệu mới thành công </br>';
}
else
{
    echo '</br>Lỗi: </br>'.mysqli_error($link).'</br>';
}
}
mysqli_close($link);  
}
}
} 

?>