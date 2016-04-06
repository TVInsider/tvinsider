<?php 
	define('WP_USE_THEMES', false); 
	//require_once('botr/api.php');
	$botr_api = new BotrAPI('fqAwzy3G','XbefBn75C72JHxAX9LDuIwuI');
	$response = $botr_api->call("/channels/videos/list",array('channel_key'=>$chankey));
	foreach ($response['videos'] as $vid) {
		if (count($vid['custom'])) {
			foreach ($vid['custom'] as &$value) {
				parse_str($value);
				if ($v) {
		    		$script = "https://www.youtube.com/watch?v=".$v;
		    		$img = "http://img.youtube.com/vi/".$v."/default.jpg";
		    	}
			}
		} else {
			$script = "http://content.jwplatform.com/videos/".$vid['key']."-iKPF85Uo.mp4";
		    $img = "http://assets-jpcust.jwpsrv.com/thumbs/".$vid['key']."-120.jpg";
		}
		echo "{image:'".$img."',file:'".$script."',title: '".$vid['title']."'},";
	} 
?>
