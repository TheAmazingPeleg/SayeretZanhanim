<?php
	include "header.php";
	if(isset($_COOKIE['uid'])){
		if($users['status'] == 0){
			echo "<script>setTimeout(function(){window.location.href = \"/status.php\";}, 0001);</script>";
		}else if($userRank['id'] > 1){
?>
<style>
.collapsible {
  background-color: #590505;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: 1px solid #f1f1f1;
  text-align: right;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #940909;
}

.content {
  display: none;
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 12px 10px 0px 10px;
}
h1 {
	opacity: 0.8;
transition-duration: 1s;
}
h1:hover {
	opacity: 1;
}
</style>
	<div class="height-70"></div>
    <!-- Start Site Content -->
    <div class="blog-site-content blog-section blog-left-sidebar">
        <div class="container">
            <div class="row">
				<?php echo $aside; ?>
                <main class="col-xl-9 col-lg-8 site-main">
				  <section class="about-us section" id="commander">
					<div class="container">
					<?php
						if(isset($_POST['askAgain'])){
							$drive = safe($_POST['row']);
							$driveSelect = $db->query("SELECT * FROM `rides` WHERE `user`='".$users['id']."' AND `id`='".$drive."' AND `status`='2' AND `start`>'".$time."'");
							if($driveSelect->num_rows == 0){
								echo error("!אין נסיעה כזאת");
							}else{
								$db->query("UPDATE `rides` SET `status`='0' WHERE `id`='".$drive."'");
								echo success("!הנסיעה נשלחה לאישור מחדש");
								echo "<script>setTimeout(function(){window.location.href = \"/myDrives.php\";}, 1000);</script>";
							}
						}
					?>
					  <center><h1 style="color: white; background-color: #1C1C1C;">נסיעות</h1></center>
					  <?php
						$selectRides = $db->query("SELECT * FROM `rides` WHERE `user`='".$users['id']."' AND `start`>'".$time."' ORDER BY `start` ASC");
						if($selectRides->num_rows > 0){
							while($row = $selectRides->fetch_assoc()){
								$askAgain = "";
								if($row['status'] == 0){
									$driveStatus = "<span style=\"color: grey\">בבדיקה</span>";
								}else if($row['status'] == 1){
									$driveStatus = "<span style=\"color: green\">מאושר</span>";
								}else if($row['status'] == 2){
									$driveStatus = "<span style=\"color: red\">לא מאושר</span>";
									$askAgain = "<form action=\"\" class=\"row contact-form\" method=\"post\">
									  <input type=\"hidden\" id=\"row\" name=\"row\" value=\"".$row['id']."\">
									  <div class=\"col-lg-6\">
									  	<button class=\"cont-submit btn-contact submit-btn tm-btn\" type=\"submit\" id=\"askAgain\" name=\"askAgain\">
										  <span>בקש בשנית</span>
										</button>
									  </div><!-- .col -->
									</form><!-- .row -->";
								}else{
									$driveStatus = "";
								}
								$authorisedBYSelect = $db->query("SELECT * FROM `users` WHERE `id`='".$row['authorisedBY']."'");
								if($authorisedBYSelect->num_rows == 0){
									$authorised = "לא הוגדר";
								}else{
									$authorisedBY = $authorisedBYSelect->fetch_assoc();
									$authorised = $authorisedBY['firstName']." ".$authorisedBY['lastName'];
								}
								$stops = "";
								if(strlen($row['stops']) > 0){
									$stops1 = " => ".$row['stops'];
									$stops2 = "עצירות: ".$row['stops']."<br />";
								}
								echo "<button type=\"button\" class=\"collapsible\"><div style=\"float: right; margin-left: 10px;\">|&nbsp;".dateCon($row['start'])."</div><div style=\"float: right\">".$row['exitLocation'].$stops1." => ".$row['destination']."&nbsp;|&nbsp;".$driveStatus."</div></button>
								  <div style=\"display: none;\">
									<div class=\"col-xl-6\" style=\"float: right\">נהג: ".$row['driver']."<br />
									מפקד נסיעה: ".$row['com']."<br />
									משלח משימה: ".$authorised."<br />
									תאריך יציאה: ".date('d/m/Y', $row['start'])."<br />
									מקומות פנויים: ".$row['seatRemaining']."</div>
									<div class=\"col-xl-6\" style=\"float: right\">שעת יציאה: ".date('H:i', $row['start'])."<br />
									שעת הגעה: ".date('H:i', $row['end'])."<br />
									מיקום יציאה: ".$row['exitLocation']."<br />
									".$stops2."
									יעד: ".$row['destination']."<br />
									סטטוס: ".$driveStatus."
									".$askAgain."</div>
								  </div>";
							}
						}else{
							echo "<button type=\"button\" class=\"collapsible\" style=\"text-align: center;\">!אין נסיעות</button>
								  <div class=\"content\">
									<p>.רענן את האתר עלמנת להתעדכן בנסיעות חדשות</p>
								  </div>";
						}
					  ?>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>
					</div>
				  </section>
                </main><!-- .col -->
            </div>
        </div>
    </div>
    <!-- End Site Content -->
	<div class="height-120"></div>
<?php
		}else{
			echo "<script>setTimeout(function(){window.location.href = \"/index.php\";}, 1000);</script>";
		}
	}else{
		echo "<script>setTimeout(function(){window.location.href = \"/index.php\";}, 1000);</script>";
	}
	include "footer.php";
?>