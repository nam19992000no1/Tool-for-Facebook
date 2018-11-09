<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php
	date_default_timezone_set('asia/ho_chi_minh');
	set_time_limit(0);
	$scan_id = $_POST['id_page'];
	$facebook_access_token= $_POST["token_fb"];
	$path = "{$scan_id}_posts.txt";
	if(file_exists($path)){
		unlink($path);
		$fp = @fopen($path, "a+");
	} else {
		$fp = @fopen($path, "a+");
	}
	$i=0;

	while ($i>=0) {
	if ($i==0){
		$url = 'https://graph.facebook.com/v3.2/'.$scan_id.'?fields=name,id,posts.limit(100){id}&access_token='.$facebook_access_token;
	} 
	else {
		if ($i==1) {
		$linkAfter = $obj->posts->paging->next;
		$url = $linkAfter;
		}
		else {
		$linkAfter = $obj->paging->next;
		if (isset($linkAfter)) {
			$url = $linkAfter;
		} else {
			//echo "Thoát quét posts</br>";
			break;
		}
		
	}
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result);
	//echo "<p> link {$i} là {$url} </p></br>";
	if ($i==0) {
		for($j=0;$j<=99;$j++){
		$id_post= $obj->posts->data[$j]->id;

			if (isset($id_post)) {
					fwrite($fp, "{$id_post}
");
			//echo "Ghi data thành công lần {$j}</br>";
			} else {
			//echo "Thoát ghi data</br>";	
			break;
			}	
		}
	}
	else {
		for($j=0;$j<=99;$j++){
		$id_post= $obj->data[$j]->id;	
		if (isset($id_post)) {
					fwrite($fp, "{$id_post}
");
			//echo "Ghi data thành công lần {$j}</br>";
			} else {
			//echo "Thoát ghi data</br>";
			break;
			}	
		}
	}   
$i++;
}
Echo "Xem và tải UID tại <a href='".$path."''> {$path} </a>";

?>
</div>