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
$url = 'https://graph.facebook.com/v2.8/'.$idgroup.'/feed?fields=reactions.summary(total_count),comments.limit(500),from,created_time,type&limit=10&access_token='.$facebook_access_token; //Token đéo được sửa
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

$member = array();
$m=0;
$postcount=0;
   class Member {
            public $classmemberid=array();
            public $classmembername=array();
            public $reactout;
            public function __construct($classmemberid,$classmembername,$reactout) {
                $this->classmemberid = $classmemberid;
                $this->classmembername = $classmembername;
                $this->reactout = $reactout;
            }
            
            public function reactecho() {
            echo $this->classmemberid." tên là ".$this->classmembername." đã like <br>";
            }
            
            public function commentecho() {
            echo $this->classmemberid." tên là ".$this->classmembername." đã comment <br>";
            }
                }
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


echo "</br>...............////////.................</br>";
echo "</br>Đang check bài viết {$idbaiviet} post bởi ".$fromnamebaiviet." |type post: ".$post_type." |time: ".$created_time." | reactions: ".$obj->data[$j]->reactions->summary->total_count." | comments ".$comment_count." </br>";

//--


require "connect_db.php";
mysql_set_charset('utf8',$link);
$link = mysqli_connect('localhost', 'sacvnnet', 'sY5C9n87ag', 'sacvnnet_group_1');

$sql = "INSERT INTO posts (post_id,post_type,member_id,member_name,post_reactions_count,post_comments_count) values ('{$idbaiviet}','{$post_type}','{$obj->data[$j]->from->id}',N'{$fromnamebaiviet}','{$obj->data[$j]->reactions->summary->total_count}','{$comment_count}');";


if($link->query($sql))
{
    echo 'Chèn dữ liệu thành công'."</br>";
}
else
{
    echo 'Lỗi: ',mysqli_error($link);
}
mysqli_close($link);

//--

echo "</br>-----------------Reactions-------------------</br>";

//-- Loop reactions
for ($k=0;$k<=100;$k++) {

array_push($memberid, $obj->data[$j]->reactions->data[$k]->id );
array_push($membername, $obj->data[$j]->reactions->data[$k]->name );
$member[$m] = new Member($memberid[$k],$membername[$k],$reactout);
$reaction_type = $obj->data[$j]->reactions->data[$k]->type;


if ($memberid[$k]>0) {
//echo $member[$m]->reactecho();
echo "id bài viết: ".$idbaiviet." |id mem: ".$memberid[$k]." |tên: ".$membername[$k]." |loại: ".$reaction_type." ";

//--


require "connect_db.php";
mysql_set_charset('utf8',$link);
$link = mysqli_connect('localhost', 'sacvnnet', 'sY5C9n87ag', 'sacvnnet_group_1');

$member_id = $idmember;
$member_name = $namemember;

$sql = "INSERT INTO reactions (post_id,member_id,member_name,reaction_type) values ('{$idbaiviet}','{$memberid[$k]}',N'{$membername[$k]}','{$reaction_type}');";


if($link->query($sql))
{
    echo 'Chèn dữ liệu thành công'."</br>";
}
else
{
    echo 'Lỗi: ',mysqli_error($link);
}
mysqli_close($link);

//--

}

$m=$m++;

} 
echo "</br>-----------------Comments-------------------</br>";
//-- Loop comments
for ($l=0;$l<=100;$l++) {
array_push($memberidcomment, $obj->data[$j]->comments->data[$l]->from->id );
array_push($membernamecomment, $obj->data[$j]->comments->data[$l]->from->name );
$member[$m] = new Member($memberidcomment[$l],$membernamecomment[$l]);
$post_type = $obj->data[$j]->type;
$created_time = $obj->data[$j]->created_time;
if ($memberidcomment[$l]>0) {
//echo $member[$m]->commentecho();
echo $memberidcomment[$l]." tên là ".$membernamecomment[$l]." đã comment <br>";

}

$m=$m++;
} 

$reactionscount = $reactionscount + $obj->data[$j]->reactions->summary->total_count;

}

$reactionscountpaging = $reactionscountpaging + $reactionscount;

}
//-- End Code Get --

?>