<?php
	include "header.php";
	if(isset($_SESSION['driver'])){
		setcookie('driver', $_SESSION['driver'], time() + (86400 * 300), "/");
	}
	if(isset($_SESSION['com'])){
		setcookie('com', $_SESSION['com'], time() + (86400 * 300), "/");
	}
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
						if(isset($_POST['submit'])){
							$driver = safe($_POST['driver']);
							$com = safe($_POST['com']);
							$exit = safe($_POST['exit']);
							$stops = safe($_POST['stops']);
							$destination = safe($_POST['destination']);
							$start = strtotime(safe($_POST['start']));
							$end = strtotime(safe($_POST['end']));
							$seats = safe($_POST['seats']);
							if(isset($_POST['remeberDriver'])){
								if($_POST['remeberDriver'] == true){
									$_SESSION['driver'] = $driver;
								}
							}
							if(isset($_POST['com'])){
								if($_POST['com'] == true){
									$_SESSION['com'] = $com;
								}
							}
							if(!preg_match('/[א-תA-Za-z]{3,50}/', $driver)){
								echo error(".שם הנהג חייב להכיל שם פרטי ומשפחה, עד 50 אותיות");
							}else if(!preg_match('/[א-תA-Za-z]{3,50}/', $com)){
								echo error(".שם מלווה הנסיעה חייב להכיל שם פרטי ומשפחה, עד 50 אותיות");
							}else if(!preg_match('/[א-תA-Za-z1-9]{3,200}/', $exit)){
								echo error(".מיקום היציאה חייב להכיל מינימום של 3 אותיות ומקסימום של 200, אותיות בעברית אנגלית ומספרים בלבד");
							}else if(!preg_match('/[א-תA-Za-z1-9]{3,200}/', $stops)){
								echo error(".העצירות חייב להכיל מקסימום של 200, אותיות בעברית אנגלית ומספרים בלבד");
							}else if(!preg_match('/[א-תA-Za-z1-9]{3,200}/', $destination)){
								echo error(".שם היעד חייב להכיל מינימום של 3 אותיות ומקסימום של 200, אותיות בעברית אנגלית ומספרים בלבד");
							}else if(!is_int($start) || !is_int($end)){
								echo alert($start);
								echo error(".הוזן תאריך ושעה בתצורה שגויה");
							}else if($start < $time){
								echo error(".התאריך והשעה אינם יכולים להיות לפני הזמן הנוכחי");
							}else if($start >= $end){
								echo error(".התאריך והשעה של ההגעה אינם יכולים להיות לפני זמן היציאה");
							}else if(!is_numeric($seats)){
								echo error(".מספר המקומות שנותרו חייב להיות ספרות בלבד");
							}else{
								$db->query("INSERT INTO `rides`(`user`, `driver`, `com`, `start`, `end`, `exitLocation`, `stops`, `destination`, `seatRemaining`, `status`, `authorisedBY`) VALUES ('".$users['id']."','".$driver."','".$com."','".$start."','".$end."','".$exit."','".$stops."','".$destination."','".$seats."','0','0')");
								echo success(".נסיעה חדשה התווספה ונשלחה לאישור");
								echo "<script>setTimeout(function(){window.location.href = \"/myDrives.php\";}, 1000);</script>";
							}
						}
					  ?>
					  <center><h1 style="margin-bottom: 20px; color: white; background-color: #1C1C1C;">נסיעה חדשה</h1></center>
					  	<form action="" class="row contact-form" method="post">
					  	  <div class="col-lg-3">
						    <div class="tm-form-field">      
							  <input type="text" id="driver" name="driver" value="<?php echo $_COOKIE['driver']; ?>" required>
							  <span class="bar"></span>
							  <label>נהג</label>
						    </div>
						  </div><!-- .col -->
					  	  <div class="col-lg-3">
							  <input type="checkbox" id="remeberDriver" name="remeberDriver">
							  <p style="text-align: center">זכור את שם הנהג</p>
						  </div><!-- .col -->
						  <div class="col-lg-3">
						    <div class="tm-form-field">      
							  <input type="text" id="com" name="com" value="<?php echo $_COOKIE['com']; ?>" required>
							  <span class="bar"></span>
							  <label>מלווה נסיעה</label>
						    </div>
						  </div>
					  	  <div class="col-lg-3">
							  <input type="checkbox" id="remeberCom" name="remeberCom">
							  <p style="text-align: center">זכור את שם המלווה</p>
						  </div><!-- .col -->
						  <div class="col-lg-4">
						    <div class="tm-form-field">      
							  <input type="text" id="exit" name="exit" required>
							  <span class="bar"></span>
							  <label>מיקום יציאה</label>
						    </div>
						  </div>
						  <div class="col-lg-4">
						    <div class="tm-form-field">      
							  <input type="text" id="stops" name="stops" required>
							  <span class="bar"></span>
							  <label>עצירות</label>
						    </div>
						  </div>
						  <div class="col-lg-4">
						    <div class="tm-form-field">      
							  <input type="text" id="destination" name="destination" required>
							  <span class="bar"></span>
							  <label>יעד</label>
						    </div>
						  </div>
						  <div class="col-lg-4">
						    <div class="tm-form-field">      
							  <input type="datetime-local" id="start" name="start" required>
							  <span class="bar"></span>
							  <label>שעת יציאה</label>
						    </div>
						  </div>
						  <div class="col-lg-4">
						    <div class="tm-form-field">      
							  <input type="datetime-local" id="end" name="end" required>
							  <span class="bar"></span>
							  <label>שעת הגעה</label>
						    </div>
						  </div>
						  <div class="col-lg-4">
						    <div class="tm-form-field">      
							  <input type="text" id="seats" name="seats" required>
							  <span class="bar"></span>
							  <label>מקומות פנויים</label>
						    </div>
						  </div>
						  <div class="col-lg-12">
						    <button class="cont-submit btn-contact submit-btn tm-btn" type="submit" id="submit" name="submit">
							  <span>שלח בקשה</span>
							</button>
						  </div>
						</form><!-- .row -->
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