<?php
require_once "config.php";
set_time_limit(0);
// -- Code Paging --
$member = array();
$m=0;
$postcount=0;
$dem=1;
for($i=0;$i<=PAGE_SCAN;$i++) {

if ($i==0) {
$url = 'https://graph.facebook.com/v2.8/'.$idgroup.'/feed?fields=full_picture,reactions.summary(total_count),comments.limit(500){message,from,created_time},from,created_time,type,message&limit=250&access_token='.$facebook_access_token; //Token không được sửa
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
//-- End Code Paging --
//-- Code get --

$postcount = $postcount+count($obj->data);
echo "<h1><a href=\"{$url}\">link {$i}</a></br></h1>";

//-- Loop bài viết
$idbaiviet=0;
for ($j=0;$j<=249;$j++) {
if (isset($obj->data[$j]->id)) {
if ($obj->data[$j]->id==$idbaiviet) {
die();
}
$m=0;

$idbaiviet = $obj->data[$j]->id;

if (isset($obj->data[$j]->from->name)) {
$fromnamebaiviet = $obj->data[$j]->from->name;
}
else {
$fromnamebaiviet = "{UNIDENTIFIED}";
}

if (isset($obj->data[$j]->from->id)) {
$fromidbaiviet = $obj->data[$j]->from->id;
}
else {
$fromidbaiviet = "";
}

if (isset($obj->data[$j]->comments->data)) {
$comment_count = count($obj->data[$j]->comments->data);
}
else {
$comment_count = 0;
}

if (isset($obj->data[$j]->message)) {
$post_content = $obj->data[$j]->message;
$post_words_count = str_word_count($post_content)-1;
}
else {
$post_content = "";
$post_words_count = 0;
}
$postcount = $postcount+count($obj->data);
$post_type = $obj->data[$j]->type;
$created_time = substr($obj->data[$j]->created_time,  0, 19);
$reactioncount = 0;
$reactioncount = $obj->data[$j]->reactions->summary->total_count;
if (isset($obj->data[$j]->full_picture)){
    $picture_url = $obj->data[$j]->full_picture;
} else {
    $picture_url = "";
}
$demhashtag=0;
$stringhashtag="";
preg_match_all('/#([\p{Pc}\p{N}\p{L}\p{Mn}]+)/u', $post_content, $matches);
foreach ($matches[0] as $hashtag) {
	$demhashtag++;
	$stringhashtag = $stringhashtag . $hashtag ."-";
	$stringhashtaglower = mb_strtolower($stringhashtag, 'UTF-8');
}

if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC_SHARE-"))==0) {
$hashtag_sacshare_check = 0;
} else {
$hashtag_sacshare_check = 1;
} if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC_TALK-"))==0) {
$hashtag_sactalk_check = 0;
} else {
$hashtag_sactalk_check = 1;
} if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC_CHILL-"))==0) {
$hashtag_sacchill_check = 0;
} else {
$hashtag_sacchill_check = 1;
} if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC_NEWS-"))==0) {
$hashtag_sacnews_check = 0;
} else {
$hashtag_sacnews_check = 1;
} if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC-"))==0) {
$hashtag_sac_check = 0;
} else {
$hashtag_sac_check = 1;
} if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC_TOPIC-"))==0) {
$hashtag_sactopic_check = 0;
} else {
$hashtag_sactopic_check = 1;
} if (strlen(strpos(mb_strtoupper($stringhashtag,'UTF-8'),"#SẮC_CMT-"))==0) {
$hashtag_saccmt_check = 0;
} else {
$hashtag_saccmt_check = 1;
}
$chars=str_split($post_content);
}

echo "</br>...............////////.................</br>";
if (isset($stringhashtaglower)) {
    echo "</br>Đang check bài viết thứ {$dem} | {$idbaiviet} | post bởi ".$fromnamebaiviet." |type post: ".$post_type." |time: ".$created_time." | reactions: ".$reactioncount." | comments ".$comment_count." </br>
Hashtag: ".$stringhashtaglower." |Hashtag Sắc check: ".$hashtag_sac_check." |Hashtag Sắcshare check: ".$hashtag_sacshare_check." Hashtag Sắctopic check: ".$hashtag_sactopic_check." Hashtag Sắccmt check: ".$hashtag_saccmt_check." |Số lượng hashtag: ".$demhashtag. " | Số từ: ".$post_words_count."</br>";
} else {
    echo "</br>Đang check bài viết thứ {$dem} | {$idbaiviet} | post bởi ".$fromnamebaiviet." |type post: ".$post_type." |time: ".$created_time." | reactions: ".$reactioncount." | comments ".$comment_count." </br>"." |Hashtag Sắc check: ".$hashtag_sac_check." |Hashtag Sắcshare check: ".$hashtag_sacshare_check." Hashtag Sắctopic check: ".$hashtag_sactopic_check." Hashtag Sắccmt check: ".$hashtag_saccmt_check." |Số lượng hashtag: ".$demhashtag. " | Số từ: ".$post_words_count."</br>";
}
$dem=$dem+1;
//--

$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link,'UTF8');
$prevQuery = 'SELECT post_id FROM posts WHERE post_id="'.$obj->data[$j]->id.'"';
if($link->query($prevQuery))
{
    echo 'Nhìn thấy dữ liệu liệu thành công |';
} else {
    echo '</br>Lỗi: </br>'.mysqli_error($link).'</br>';
}
$prevResult = $link->query($prevQuery);
if($prevResult->num_rows > 0){
    if (isset($stringhashtaglower)) {
    $query = "UPDATE posts SET post_reactions_count = {$reactioncount},post_comments_count = {$comment_count}, post_content = '{$post_content}',picture_url = '{$picture_url}',hashtag_used='{$stringhashtaglower}',hashtag_sac_check={$hashtag_sac_check},hashtag_sacshare_check={$hashtag_sacshare_check},hashtag_sactopic_check={$hashtag_sactopic_check},hashtag_sacnews_check={$hashtag_sacnews_check},hashtag_sactalk_check={$hashtag_sactalk_check},hashtag_sacchill_check={$hashtag_sacchill_check},hashtag_saccmt_check={$hashtag_saccmt_check},hashtag_count={$demhashtag},post_words_count={$post_words_count} WHERE post_id='".$obj->data[$j]->id."'";
} else {
    $query = "UPDATE posts SET post_reactions_count = {$reactioncount},post_comments_count = {$comment_count}, post_content = '{$post_content}',picture_url = '{$picture_url}',hashtag_sac_check={$hashtag_sac_check},hashtag_sacshare_check={$hashtag_sacshare_check},hashtag_sactopic_check={$hashtag_sactopic_check},hashtag_sacnews_check={$hashtag_sacnews_check},hashtag_sactalk_check={$hashtag_sactalk_check},hashtag_sacchill_check={$hashtag_sacchill_check},hashtag_saccmt_check={$hashtag_saccmt_check},hashtag_count={$demhashtag},post_words_count={$post_words_count} WHERE post_id='".$obj->data[$j]->id."'";
    }
if ($link->query($query)) {
        echo ' Cập nhật dữ liệu thành công</br>';
    } else  {
    echo '</br>Lỗi cập nhật: </br>'.mysqli_error($link).'</br>';
            }
} else {
$query = "INSERT INTO posts (post_id,post_created_time,post_type,member_id,member_name,post_reactions_count,post_comments_count,post_content,picture_url,hashtag_used,hashtag_sac_check,hashtag_sacshare_check,hashtag_sactopic_check,hashtag_sacnews_check,hashtag_sactalk_check,hashtag_sacchill_check,hashtag_saccmt_check,hashtag_count,post_words_count) VALUES ('{$idbaiviet}','{$created_time}','{$post_type}','{$fromidbaiviet}','{$fromnamebaiviet}','{$reactioncount}','{$comment_count}',N'{$post_content}','{$picture_url}',N'{$stringhashtaglower}','{$hashtag_sac_check}','{$hashtag_sacshare_check}','{$hashtag_sactopic_check}','{$hashtag_sacnews_check}','{$hashtag_sactalk_check}','{$hashtag_sacchill_check}','{$hashtag_saccmt_check}','{$demhashtag}','{$post_words_count}');";

if ($link->query($query)) {
        echo ' Thêm dữ liệu thành công</br>';
    } else  {
    echo '</br>Lỗi thêm dữ liệu: </br>'.mysqli_error($link).'</br>';
            }
}
mysqli_close($link);  
unset($stringhashtaglower);

echo "</br>-----------------Reactions-------------------</br>";
$memberid=array();
$membername=array();
//-- Loop reactions
for ($k=0;$k<=100;$k++) {
if (isset($obj->data[$j]->reactions->data[$k]->id)) {
$memberidpush = $obj->data[$j]->reactions->data[$k]->id;
$membernamepush = $obj->data[$j]->reactions->data[$k]->name;
array_push($memberid, $memberidpush );
array_push($membername, $membernamepush );
$reaction_type = $obj->data[$j]->reactions->data[$k]->type;

if ($memberid[$k]>0) {
echo "id bài viết: ".$idbaiviet." |id mem: ".$memberid[$k]." |tên: ".$membername[$k]." |loại: ".$reaction_type." ";
$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link,'UTF8');
$prevQuery = 'SELECT post_id,member_id FROM reactions WHERE post_id="'.$idbaiviet.'" AND member_id="'.$memberid[$k].'"';
if($link->query($prevQuery))
{
    echo 'Nhìn thấy dữ liệu liệu thành công |';
} else {
    echo '</br>Lỗi nhìn dữ liệu: </br>'.mysqli_error($link).'</br>';
}
$prevResult = $link->query($prevQuery);
if($prevResult->num_rows > 0){
    $query = "UPDATE reactions SET reaction_type='{$reaction_type}' WHERE post_id='".$idbaiviet."' AND member_id='".$memberid[$k]."'";
    if ($link->query($query)) {
        echo ' Cập nhật dữ liệu thành công</br>';
    } else  {
    echo '</br>Lỗi cập nhật: </br>'.mysqli_error($link).'</br>';
            }
} else {
$query = "INSERT INTO reactions (post_id,member_id,reaction_type) values ('{$idbaiviet}','{$memberid[$k]}','{$reaction_type}');";
if ($link->query($query)) {
        echo ' Thêm dữ liệu thành công</br>';
    } else  {
    echo '</br>Lỗi thêm dữ liệu: </br>'.mysqli_error($link).'</br>';
            }
}
mysqli_close($link);
} 
//--

}

$m=$m++;

} 
echo "</br>-----------------Comments-------------------</br>";
//-- Loop comments
$memberidcomment=array();
$membernamecomment=array();

for ($l=0;$l<=100;$l++) {
if (isset($obj->data[$j]->comments->data[$l]->from->id)) {
$comment_id = $obj->data[$j]->comments->data[$l]->id;

array_push($memberidcomment, $obj->data[$j]->comments->data[$l]->from->id );
array_push($membernamecomment, $obj->data[$j]->comments->data[$l]->from->name );
//$member[$m] = new Member($memberidcomment[$l],$membernamecomment[$l]);
$post_type = $obj->data[$j]->type;
$comment_created_time = substr($obj->data[$j]->comments->data[$l]->created_time,  0, 19);
if ($memberidcomment[$l]>0) {
//echo $member[$m]->commentecho();
$comment_content = $obj->data[$j]->comments->data[$l]->message;
$comment_char_count = strlen($obj->data[$j]->comments->data[$l]->message);
echo $memberidcomment[$l]." tên là ".$membernamecomment[$l]." đã comment ".$comment_char_count." kí tự ".$comment_id." là id comment |";
//-- Code Database 
$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link,'UTF8');
$prevQuery = 'SELECT comment_id FROM comments WHERE comment_id ='.$comment_id;
if($link->query($prevQuery)) {
    echo 'Nhìn thấy dữ liệu liệu thành công |';
} else  {
    echo '</br>Lỗi nhìn dữ liệu: </br>'.mysqli_error($link).'</br>';
        }
$prevResult = $link->query($prevQuery);
if($prevResult->num_rows > 0){
    $query = "UPDATE comments SET comment_content=N'{$comment_content}',comment_char_count='{$comment_char_count}' WHERE comment_id={$comment_id}";
    if($link->query($query))
{
    echo ' Cập nhật dữ liệu thành công</br>';
}
else
{
    echo '</br>Lỗi cập nhật: </br>'.mysqli_error($link).'</br>';
}
} else {
    $query = "INSERT INTO comments (post_id,member_id,comment_content,comment_id,comment_created_time,comment_char_count) values ('{$idbaiviet}','{$memberidcomment[$l]}',N'{$comment_content}','{$comment_id}','{$comment_created_time}','{$comment_char_count}')";
    if($link->query($query))
{
    echo 'Thêm dữ liệu mới thành công </br>';
}
else
{
    echo '</br>Lỗi thêm dữ liệu : </br>'.mysqli_error($link).'</br>';
}
}
	mysqli_close($link); 
}
//-- End code Database 
}
$m=$m++;
} 
}
}
//-- End Code Get --

?>