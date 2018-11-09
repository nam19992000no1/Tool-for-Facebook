<?php

require "config.php";
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
 mysqli_set_charset($conn,'UTF8');

$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($link,'UTF8');
$sql = array();
array_push($sql,"UPDATE ranking SET count_comment = ( SELECT count( member_id ) AS count_comment
FROM comments
WHERE ranking.member_id = comments.member_id AND DATEDIFF( now( ) , comment_created_time ) <=30 );");
array_push($sql,"UPDATE reactions SET reaction_created_time = (SELECT post_created_time 
FROM posts
WHERE reactions.post_id = posts.post_id);");
array_push($sql,"
UPDATE ranking SET count_reaction = ( SELECT count( member_id ) AS count_comment
FROM reactions
WHERE ranking.member_id = reactions.member_id AND DATEDIFF( now( ) , reaction_created_time ) <=30 ) ;");
array_push($sql,"UPDATE ranking SET count_reaction_in = (
SELECT sum( post_reactions_count )
FROM posts
WHERE ranking.member_id = posts.member_id AND DATEDIFF( now( ) , post_created_time ) <=30
);");
array_push($sql,"UPDATE ranking SET count_comment_in = (
SELECT sum( post_comments_count )
FROM posts
WHERE ranking.member_id = posts.member_id AND DATEDIFF( now( ) , post_created_time ) <=30
);");
array_push($sql,"UPDATE ranking SET count_hashtag_sac = (
SELECT sum( hashtag_sac_check )
FROM posts
WHERE ranking.member_id = posts.member_id AND DATEDIFF( now( ) , post_created_time ) <=30
);");
array_push($sql,"UPDATE ranking SET count_hashtag_sacshare = (
SELECT sum( hashtag_sacshare_check )
FROM posts
WHERE ranking.member_id = posts.member_id AND DATEDIFF( now( ) , post_created_time ) <=30
);");
array_push($sql,"UPDATE ranking
SET count_type_status = (
SELECT count( post_type )
FROM posts
WHERE ranking.member_id=posts.member_id AND post_type = 'link' AND DATEDIFF( now( ) , post_created_time ) <=30
);");
array_push($sql,"UPDATE ranking SET count_type_image = ( SELECT count( post_type )
FROM posts
WHERE ranking.member_id = posts.member_id
AND post_type = 'photo' AND DATEDIFF( now( ) , post_created_time ) <=30) ;");
array_push($sql,"UPDATE ranking SET member_point = count_comment*2.5 + count_reaction*0.4 + count_reaction_in*1.4 + count_comment_in*0.4+count_type_image*7+count_type_status*3+count_hashtag_sac*2+count_hashtag_sacshare*3.5, member_influent = count_comment*0.9 + count_reaction_in*0.6 + count_comment_in*1;");

For ($i=0;$i<=9;$i++){
if($link->query($sql[$i]))
{
    echo $i." "."Tính ranking thành công</br>".$sql[$i]."</br>";
}
else
{
    echo 'Lỗi: </br>',mysqli_error($link);
} 
}
mysqli_close($link); 

?>