<?php
header("Refresh:120");
date_default_timezone_set('asia/ho_chi_minh');

$id = '100000270155390_1039970059440184'; // ID post Status moi nhat
$idgroup = '735969126506947';
$facebook_access_token='EAAAACZAVC6ygBAC6Jklq6ivcEGgGV6j4M0Q9AHnvyUcgJYyATDKPW5OE6i0Bt5wZATVfrW8opZA8WwyvumUErGyBXpV5LRc9qYkRwhOrQEd6LlgWSXDS9bvZB73vFPY9kqyZAr2Xr5ZBks5saXI1HvmBGoOMOhNkwZD'; // Token full quyen



// -- Hàm CURL --
function Curl($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
}
// -- End CURL --

// -- Code Paging --
$url = 'https://graph.facebook.com/v2.8/'.$idgroup.'/feed?fields=reactions.summary(total_count),comments.limit(500),from,created_time,type,message&limit=10&access_token='.$facebook_access_token; //Token đéo được sửa
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
echo "link 0 là {$url}</br>";
//-- End Code Paging --
//-- Code get --

for($i=1;$i<=5;$i++) {
$linkAfter = $obj->paging->next;
$url = $linkAfter; //Token đéo được sửa
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch); 
$obj = json_decode($result);
$postcount = $postcount+count($obj->data);
echo "</br>link {$i} là {$url}<br>";

//-- Loop bài viết
for ($j=0;$j<=9;$j++) {
$m=0;
$memberid=array();
$membername=array();
$memberidcomment=array();
$membernamecomment=array();
$idbaiviet = $obj->data[$j]->id;
$fromnamebaiviet = $obj->data[$j]->from->name;
$comment_count = count($obj->data[$j]->comments->data);


$postcount = $postcount+count($obj->data);
$post_type = $obj->data[$j]->type;

$created_time = $obj->data[$j]->created_time;
$noidungbaiviet = $obj->data[$j]->message;

echo "</br>...............////////.................</br>";
echo "</br>Đang check bài viết {$idbaiviet} post bởi ".$fromnamebaiviet;



echo mb_strtoupper($noidungbaiviet,'UTF-8')." </br>";



if (strlen(strpos(mb_strtoupper($noidungbaiviet,'UTF-8'),"#SẮCSHARE"))==0) {
echo "- Thiếu hashtag Sắcshare";
$hashtag_sacshare_check = 0;
echo $hashtag_sacshare_check;
}
else {
echo "- Có hashtag Sắcshare";
$hashtag_sacshare_check = 1;
echo $hashtag_sacshare_check;
}

if (strlen(strpos(mb_strtoupper($noidungbaiviet,'UTF-8'),"#SẮC"))==0) {
echo "- Thiếu hashtag Sắc";
$hashtag_sac_check = 0;
echo $hashtag_sac_check;
}
else {
echo "- Có hashtag Sắc";
$hashtag_sac_check = 1;
echo $hashtag_sac_check;
}


}
}

?>