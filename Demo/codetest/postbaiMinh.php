<?php
header("Refresh:120");
date_default_timezone_set('asia/ho_chi_minh');

$id = '100000270155390_1039970059440184'; // ID post Status moi nhat
$idgroup = '735969126506947';
$facebook_access_token='EAAAAUaZA8jlABAANvNnRYpxvWLZCeHVkHQyczMItU6rCRtbPndurDLriPOcN4Wu18XK9EZBZCQnA47Es9mdjvMJxZACeKOBRhwAIkGiJ2CUpD4yfNlqax5Jsr5uj2DZAyZCbZANZACU6959cGfoICZAspL5Fg4kz6uCKI083MJb280YAZDZD'; 
$facebook_group_access_token='EAACEdEose0cBAN8zTKzSZAilpTHHDF8Rg0Teq0kIMuIsxW7DGsfWEZBSq0JJPEUodS4DdI8zdFdayfSX9AwsEuVur25uMeoryP3T5V9Dx5u1XuKcK3IOXdl5xS8JMoRbkZAS5kzs2evkuwv7N41nTZAY1zslFC7aDocm7PY8SndsI4ZC1fM0QdsJxZAZCfwKa0ZD'; // Token full quyen


// -- Bat dau lay ra reaction moi nhat -- 
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=reactions.limit(1000),comments&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$iid =  $obj->$id->reactions->data[0]->id; //Tra ra id
$name =  $obj->$id->reactions->data[0]->name; //Tra ra Tên
$type =  $obj->$id->reactions->data[0]->type; // Tra ra Reaction
$time = date("h:i:s d/m/y"); // Tra ra Thoi gian hien tai
$reaction = $obj->$id->reactions->data; //Test tra so luong reactions
$comment = $obj->$id->comments->count; //Test tra so luong reactions
$countcomment = count($comment);
$countreaction = count($reaction);

// -- Ket thúc --


// -- Bat dau review info group --
$url = 'https://graph.facebook.com/'.$idgroup.'?fields=members.limit(1000).summary(total_count),member_request_count&access_token='.$facebook_group_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$membercount = $obj->$idgroup->members->summary->total_count;
$memberrequestcount = $obj->$idgroup->members_request_count;

// -- Ket thuc --


// -- Bat dau review feed group va lay buc hinh moi nhat --
$url = 'https://graph.facebook.com/v2.8/?ids='.$idgroup.'?fields=feed.type(photo)&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$idlatestpost = $obj->$id->feed->data[0]->id;

// -- Ket thuc --

// -- Bat dau count so luong love --
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=reactions.type(LOVE).limit(1000).summary(total_count)&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$countlove =  $obj->$id->reactions->summary->total_count; //Tra ra so luong likes
$iidlove =  $obj->$id->reactions->data[0]->id; //Tra ra id
$namelove =  $obj->$id->reactions->data[0]->name; //Tra ra Tên


// -- Ket thuc --
// -- Bat dau count so luong angry --
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=reactions.type(ANGRY).limit(1000).summary(total_count)&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$countangry =  $obj->$id->reactions->summary->total_count; //Tra ra so luong 
$iidangry =  $obj->$id->reactions->data[0]->id; //Tra ra id
$nameangry =  $obj->$id->reactions->data[0]->name; //Tra ra Tên

// -- Ket thuc --
// -- Bat dau count so luong haha --
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=reactions.type(HAHA).limit(1000).summary(total_count)&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$counthaha =  $obj->$id->reactions->summary->total_count; //Tra ra so luong 
$iidhaha =  $obj->$id->reactions->data[0]->id; //Tra ra id
$namehaha =  $obj->$id->reactions->data[0]->name; //Tra ra Tên

// -- Ket thuc --


// -- Bat dau count so luong sad --
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=reactions.type(SAD).limit(1000).summary(total_count)&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$countsad =  $obj->$id->reactions->summary->total_count; //Tra ra so luong 
$iidsad =  $obj->$id->reactions->data[0]->id; //Tra ra id
$namesad =  $obj->$id->reactions->data[0]->name; //Tra ra Tên

// -- Ket thuc --

// -- Bat dau count so luong wow --
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=reactions.type(WOW).limit(1000).summary(total_count)&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$countwow =  $obj->$id->reactions->summary->total_count; //Tra ra so luong 
$iidwow =  $obj->$id->reactions->data[0]->id; //Tra ra id
$namewow =  $obj->$id->reactions->data[0]->name; //Tra ra Tên

// -- Ket thuc --

// -- Bat dau count so luong reaction can thiet de hien bai viet, sua thanh like hay love deu dc --
$url = 'https://graph.facebook.com/v2.8/?ids='.$id.'&fields=likes&access_token='.$facebook_access_token;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);
$obj = json_decode($result);
$like =  $obj->$id->likes->count; //Tra ra so luong likes

$du= $membercount; //Tinh so likes con thieu

// -- Ket thuc --




// Ðây là phần nội dung cập nhật trên Status mới nhất.

echo $status =
"
[Không liên quan/Test] Test một vài tính năng nâng cao hơn
---------------------------------------------------------
Group Sắc có {$membercount} thành viên và {$memberrequestcount} bạn đang đệ đơn gia nhập. Status này có {$countreaction} cảm xúc, trong đó:

{$like} bạn đã like
{$countlove} bạn đã bắn tym, bạn @[{$iidlove}:0.{$namelove}:0] tym gần đây nhất
{$counthaha} bạn đã cười haha, bạn @[{$iidhaha}:0.{$namehaha}:0] cười gần đây nhất
{$countwow} bạn đã ngạc nhiên vcl, bạn @[{$iidwow}:0.{$namewow}:0] ngạc cmn nhiên gần đây nhất
{$countangry} bạn đã tức giận, không ai khác chính là bạn @[{$iidangry}:0.{$nameangry}:0]
{$countsad} bạn đã buồn, mình không hiểu vì sao bạn @[{$iidsad}:0.{$namesad}:0] buồn :(


Bài viết mới nhất gần đây post bởi bạn @[{$iidlatestpost}:0.{$namelatestpost}:0] và đã có {$reactionlatestpost} bạn thả cảm xúc

Còn {$du} bạn chưa thả cảm xúc cho status này
---------------------------------------------------------
Status cập nhật lần cuối lúc $time
Mỗi 1 phút status tự động cập nhật 1 lần nhé các bác

";



//return;
// -- Code viet, edit status
$params = array('access_token'=>$facebook_access_token, 'message'=>$status);
$url = "https://graph.facebook.com/".$id;
$ch = curl_init();
curl_setopt_array($ch, array(
	CURLOPT_URL => $url,
	CURLOPT_POSTFIELDS => $params,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_VERBOSE => true
	));
$result = curl_exec($ch);
// -- Ket thuc --
// -- Phan code cho comment --

var_dump($result);
?>