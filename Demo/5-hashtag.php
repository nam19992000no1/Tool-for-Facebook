<? 
$link = mysqli_connect('localhost', 'sacvnnet_community', 'T-k(WTZ%*t5@', 'sacvnnet_group_1');
echo '-------------Bắt đầu Truncate Table--------------</br>';
$sql = "TRUNCATE TABLE hashtags";
if($link->query($sql))
{
	echo "Truncate thành công dữ liệu bảng hashtags</br>";
}
else
{
    echo 'Lỗi: ',mysqli_error($link);
}
echo '-------------Truncate thành công--------------</br>'; 
require_once 'connect_db.php';
$sql='
SELECT hashtag_used
FROM posts p';
$retval = mysqli_query($link,$sql);
If (! $retval )
{
die('Could not get data: '. mysql_error());
}


$hashtag_used = array();

/* Trích xuất string hashtag từ SQL */
$i=0;
While ($row = mysqli_fetch_array($retval, MYSQL_ASSOC))
{
array_push($hashtag_used,$row['hashtag_used']);
$i++;
}

             $hashtagstring = "";
             for($i=0;$i<=6000;$i++){
                 if(isset($hashtag_used[$i])){
$hashtagstring = $hashtagstring . $hashtag_used[$i];
}
}

/* Nối văn bản */
$stringhashtaglong = "";
$hashtagall = array();
preg_match_all('/#([\p{Pc}\p{N}\p{L}\p{Mn}]+)/u', $hashtagstring, $matches2);
foreach ($matches2[0] as $hashtag) {  
	$stringhashtaglong = $stringhashtaglong . $hashtag ."-";
	array_push($hashtagall, $hashtag);
}


/* Quét hashtag unique */
    $hashtags= FALSE;  
    preg_match_all("/(#\w+)/u", $hashtagstring, $matches);  
    if ($matches) {
        $hashtagsArray = array_count_values($matches[0]);
        $hashtags = array_keys($hashtagsArray);    
    }
    
    /* Danh sách hashtag bị loại bỏ */
    $list_hashtag_no = array('#sắc','#vdpc','#vđpc','#săc','#xincmt','#apc','#csc','#sac','#bẹp','#neography','#bachphotography','#cnn','#cnh','#sắc_chủđề','#bejp','#sắc_topic','#sắc_news','#sắc_cmt','#bbz10','#ivd');
    
    /* Vòng lặp quét hashtag hợp lệ*/
    for($i=0;$i<count($hashtags);$i++)
    {
     $hashtag_count = count(array_keys($hashtagall, $hashtags[$i]));
     $hashtag_accepted = array_diff($hashtags, $list_hashtag_no); 
     if ($hashtag_count>=5&&in_array($hashtags[$i], $hashtag_accepted)&&strlen($hashtags[$i])>2) {
      
     echo '</br><a target="_blank" href="https://facebook.com/hashtag/'.trim($hashtag_accepted[$i], "#").'?filters_rp_author=735969126506947">'.$hashtag_accepted[$i].'</a>';
     echo $hashtag_count." ";
     
     //-------Update Database

$sql = "INSERT INTO hashtags (hashtag, hashtag_count) values ('{$hashtags[$i]}','{$hashtag_count}');";
if($link->query($sql))
{
    echo ' Chèn dữ liệu thành công ';
}
else
{
    echo 'Lỗi: </br>',mysqli_error($link);
}

}} 
?>

  