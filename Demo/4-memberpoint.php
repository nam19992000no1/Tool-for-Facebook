<?php
require "connect_db.php";
$link = mysqli_connect('localhost', 'sacvnnet_community', 'T-k(WTZ%*t5@', 'sacvnnet_group_1');
$sql = array();
array_push($sql,"UPDATE members SET count_comment = ( SELECT count( member_id ) AS count_comment
FROM comments
WHERE members.member_id = comments.member_id) ; ");
array_push($sql,"UPDATE members SET count_reaction = ( SELECT count( member_id ) AS count_comment
FROM reactions
WHERE members.member_id = reactions.member_id);");
array_push($sql,"UPDATE members SET count_reaction_in = (
SELECT sum( post_reactions_count )
FROM posts
WHERE members.member_id = posts.member_id 
);");
array_push($sql,"UPDATE members SET count_comment_in = (
SELECT sum( post_comments_count )
FROM posts
WHERE members.member_id = posts.member_id 
);");
array_push($sql,"UPDATE members SET count_hashtag_sac = (
SELECT sum( hashtag_sac_check )
FROM posts
WHERE members.member_id = posts.member_id
);");
array_push($sql,"UPDATE members SET count_hashtag_sacshare = (
SELECT sum( hashtag_sacshare_check )
FROM posts
WHERE members.member_id = posts.member_id 
);");
array_push($sql,"UPDATE members
SET count_type_status = (
SELECT count( post_type )
FROM posts
WHERE members.member_id=posts.member_id AND post_type = 'link' 
);");
array_push($sql,"UPDATE members SET count_type_image = ( SELECT count( post_type )
FROM posts
WHERE members.member_id = posts.member_id
AND post_type = 'photo' ) ;");
array_push($sql,"UPDATE members SET member_point = count_comment*2.5 + count_reaction*0.4 + count_reaction_in*1.4 + count_comment_in*0.4+count_type_image*7+count_type_status*3+count_hashtag_sac*2+count_hashtag_sacshare*3.5, member_influent = count_comment*0.9 + count_reaction_in*0.6 + count_comment_in*1;");
For ($i=0;$i<=8;$i++){
if($link->query($sql[$i]))
{
    echo $i." "."Tính điểm member thành công</br>".$sql[$i]."</br>";
}
else
{
    echo 'Lỗi: </br>',mysqli_error($link);
} 
}
mysqli_close($link); 

?>