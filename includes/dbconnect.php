<?php
function get_my_db()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sayeret";
    static $db;

    if (!$db) {
        $db = new mysqli($servername, $username, $password, $dbname);
    }

    return $db;
}
$db = get_my_db();
// Check connection
if ($db->connect_error) {
	echo "<script>
		window.alert('".die("Connection failed: (".$mysqli->connect_errno.") " . $db->connect_error)."');
	</script>";
}
$db->query("SET NAMES 'utf8'");

function getUserIP() {
	$clienglisht  = @$_SERVER['HTTP_CLIenglishT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];
		if(filter_var($clienglisht, FILTER_VALIDATE_IP))
	{
		$ip = $clienglisht;
	}
	elseif(filter_var($forward, FILTER_VALIDATE_IP))
	{
		$ip = $forward;
	}
	else
	{
		$ip = $remote;
	}
		return $ip;
}
$user_ip = getUserIP();
if(isset($_COOKIE['uid'])){
	$users_select = $db->query("SELECT * FROM `users` WHERE `id`='".$_COOKIE['uid']."'");
	if($users_select->num_rows > 0){
		//user's data
		$users = $users_select->fetch_assoc();
		$userRank_select = $db->query("SELECT * FROM `ranks` WHERE `id`='".$users['rank']."'");
		if($userRank_select->num_rows == 0){
			$updateRank = $db->query("UPDATE `users` SET `rank`='1' WHERE `id`='".$users['id']."'");
			$userRank_select = $db->query("SELECT * FROM `ranks` WHERE `id`='".$users['rank']."'");
		}
		$userRank = $userRank_select->fetch_assoc();
		if(!isset($_COOKIE['driver'])){
			$_COOKIE['driver'] = "";
		}
		if(!isset($_COOKIE['com'])){
			$_COOKIE['com'] = "";
		}
	}else{
		unset($_COOKIE['uid']); 
		setcookie('uid', null, -1, '/'); 
		echo "<script>setTimeout(function(){window.location.href = \"/index.php\";}, 1000);</script>";
	}
}

//functions
function safe($text){
	$db = get_my_db();
	$text = str_replace(",","",$text);
	$text = $db->real_escape_string(addslashes(strip_tags(htmlspecialchars($text))));
	return $text;
}
function safeNoStrip($text){
	$db = get_my_db();
	$text = str_replace("script","",$text);
	$text = str_replace("onclick","",$text);
	$text = $db->real_escape_string($text);
	return $text;
}
function password($text){
	$db = get_my_db();
	$text = md5(sha1(md5(sha1($db->real_escape_string($text)).sha1($db->real_escape_string($text)))));
	return $text;
}
/*function text($name){
	$db = get_my_db();
	$text = $db->query("SELECT * FROM `text` WHERE `name`='".$name."'");
	$text = $text->fetch_assoc();
	return $text['text'];
}*/
function success($text){
	return "".$text."";
}
function error($text){
	return "".$text."";
}
function alert($text){
	return "<script>window.alert('".$text."');</script>";
}
function dateCon($date){
	return date('H:i d/m/Y', $date);
}
if(isset($_COOKIE['uid'])){
	$notifications = "";
	$selectRides = $db->query("SELECT * FROM `rides` WHERE `status`='0'");
	if($userRank['id'] == 4){
		if($selectRides->num_rows > 0){
			$i = 0;
			while($ride = $selectRides->fetch_assoc()){
				if(date('H',$ride['start']) < 22 && date('H',$ride['start']) > 5){
					$i ++;
				}
			}
			if($i > 0){
				$notifications = "(".$i.")";
			}
		}
	}
	if($userRank['id'] == 5){
		if($selectRides->num_rows > 0){
			$i = 0;
			while($ride = $selectRides->fetch_assoc()){
				if(date('H',$ride['start']) > 22 || date('H',$ride['start']) < 6){
					$i ++;
				}
			}
			if($i > 0){
				$notifications = "<span style=\"color: black\">(".$i.")</span>";
			}
		}
	}
	$aside = "<aside class=\"col-xl-3 col-lg-4 sidebar\">
            <section class=\"widget widget_categories\">
              <center><h2 class=\"widget-title\" style=\"font-size: 2em;\">אפשרויות</h2></center>
              <h2 class=\"widget-title\">נסיעות</h2>
                <ul>
                  <li><a href=\"/panel.php\">נסיעות</a></li>";
	if($userRank['id'] > 3){
		$aside = $aside."<li><a href=\"/drivesApproval.php\">".$notifications." אישור בקשות</a></li>";
	}
	if($userRank['id'] > 1){
		$aside = $aside."<li><a href=\"/myDrives.php\">נסיעות שלי</a></li><li><a href=\"/newDrive.php\">בקשת נסיעה</a></li>";
	}
	$aside = $aside."</ul>
			</section><!-- .widget -->";
	if($userRank['id'] > 2){
		$aside = $aside."<section class=\"widget widget_categories\">
			<h2 class=\"widget-title\">עריכה</h2>
                <ul>
                  <li><a href=\"/edit.php\">עריכת עמודים פרונטליים</a></li>";
                  if($userRank['id'] > 3){
					$aside = $aside."<li><a href=\"/newUser.php\">הוספת משתמש</a></li>
					<li><a href=\"/editUsers.php\">עריכת משתמשים</a></li>";
				  }
		$aside = $aside."</ul>
			</h2>
		</section><!-- .widget -->";
	}
	$aside = $aside."</aside>";
}
$time = time() + (2 * 60 * 60);
$date = dateCon($time);

?>
