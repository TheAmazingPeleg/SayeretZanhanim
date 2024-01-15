<?php
	include "header.php";
	if(isset($_SESSION['driver'])){
		setcookie('driver', $_SESSION['driver'], time() + (86400 * 300), "/");
	}
	if(isset($_SESSION['com'])){
		setcookie('com', $_SESSION['com'], time() + (86400 * 300), "/");
	}
	if(isset($_COOKIE['uid'])){
		if($userRank['id'] > 1){
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
							$username = safe($_POST['username']);
							$email = safe($_POST['email']);
							$passwordSafe = safeNoStrip($_POST['password']);
							$password = password($_POST['password']);
							$firstName = safe($_POST['firstName']);
							$lastName = safe($_POST['lastName']);
							$rank = safe($_POST['rank']);
							$stmt1 = $db->query("SELECT * FROM `users` WHERE `email`='".$email."'");
							$stmt2 = $db->query("SELECT * FROM `users` WHERE `username`='".$username."'");
							$stmt3 = $db->query("SELECT * FROM `ranks` WHERE `id`='".$rank."'");
							$email_message ="נרשמת בהצלחה לאתר סיירת צנחנים ! \r\nפרטי המשתמש:\r\nשם משתמש: ".$username." \r\nסיסמא: ".$password." \n\r\nלהתחברות: http://sayaretzahanim.co.il\login.php";
							if($users['rank'] < 4){
								echo error(".דרגת ".$rank['name']." לא יכל להוסיף משתמשים");
							}else if(!preg_match('/[א-תA-Za-z]{3,50}/', $username)){
								echo error(".שם המשתמש חייב להכיל 3 עד 50 אותיות");
							}else if($stmt2->num_rows > 0){
								echo error("!שם המשתמש קיים במערכת");
							}else if(!preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/', $email) || strlen($email) > 200){
								echo error(".המייל חייב להכיל נוסח של מייל");
							}else if($stmt1->num_rows > 0){
								echo error("!המייל קיים במערכת");
							}else if(!preg_match('/[א-תA-Za-z]{2,50}/', $firstName)){
								echo error(".השם חייב להיות בין 2 עד 50 אותיות");
							}else if(!preg_match('/[א-תA-Za-z]{2,50}/', $lastName)){
								echo error(".שם המשפחה חייב להיות בין 2 עד 50 אותיות");
							}else if(!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,200}/', $passwordSafe)){
								echo error(".הסיסמא חייבת להיות מעל ל8 תווים בעלת אותיות באנגלית, המכילה לפחות אות אחת גדולה וסיפרה");
							}else if($stmt3->num_rows == 0){
								echo error(".הדרגה שהוזנה אינה אחת מהאופציות");
							}else if($users['rank'] < 5 && $rank > 2){
								echo error(".דרגת ".$rank['name']." לא יכל להוסיף משתמש בדרגה מסוג זה");
							}else if($users['rank'] <= $rank){
								echo error(".דרגת ".$rank['name']." לא יכל להוסיף משתמש בדרגה מסוג זה");
							}else{
								$db->query("INSERT INTO `users`(`username`, `email`, `password`, `firstName`, `lastName`, `rank`, `status`) VALUES ('".$username."','".$email."','".$password."','".$firstName."','".$lastName."','".$rank."','1')");
								$to = $email;
								$subject = "פרטי הרשמה לאתר סיירת";
								$headers = "From: sayeretzanhanim@gmail.com\r\n";
								$headers .= "Reply-To: sayeretzanhanim@gmail.com\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=utf-8\r\n";
								if(mail($to, $subject, $email_message, $headers)){
									echo success(".המשתמש נוסף ונשלח לו מייל עם פרטי המשתמש");
									echo "<script>setTimeout(function(){window.location.href = \"/newUser.php\";}, 1000);</script>";
								}else{
									echo error(".המשתמש נוסף אח לא נשלח מייל");
									echo "<script>setTimeout(function(){window.location.href = \"/newUser.php\";}, 1000);</script>";								}
							}
						}
					  ?>
					  <center><h1 style="margin-bottom: 20px; color: white; background-color: #1C1C1C;">משתמש חדש</h1></center>
					  	<form action="" class="row contact-form" method="post">
					  	  <div class="col-lg-6">
						    <div class="tm-form-field">      
							  <input type="text" id="username" name="username" required>
							  <span class="bar"></span>
							  <label>שם משתמש</label>
						    </div>
						  </div><!-- .col -->
					  	  <div class="col-lg-6">
						    <div class="tm-form-field">      
							  <input type="email" id="email" name="email" required>
							  <span class="bar"></span>
							  <label>מייל</label>
						    </div>
						  </div><!-- .col -->
					  	  <div class="col-lg-6">
						    <div class="tm-form-field">      
							  <input type="password" id="password" name="password" required>
							  <span class="bar"></span>
							  <label>סיסמא</label>
						    </div>
						  </div><!-- .col -->
					  	  <div class="col-lg-6">
						    <div class="tm-form-field">      
							  <select id="rank" name="rank">
								<?php
									$stmt = $db->query("SELECT * FROM `ranks`");
									if($stmt->num_rows > 0){
										while($row = $stmt->fetch_assoc()){
											$selected = "";
											if($row['id'] == 2){
												$selected = "selected";
											}
											echo "<option value=\"".$row['id']."\" ".$selected." style=\"text-align: center;\">".$row['name']."</option>";
										}
									}									
								?>
							  </select>
						    </div>
						  </div><!-- .col -->
					  	  <div class="col-lg-6">
						    <div class="tm-form-field">      
							  <input type="text" id="firstName" name="firstName" required>
							  <span class="bar"></span>
							  <label>שם פרטי</label>
						    </div>
						  </div><!-- .col -->
					  	  <div class="col-lg-6">
						    <div class="tm-form-field">      
							  <input type="text" id="lastName" name="lastName" required>
							  <span class="bar"></span>
							  <label>שם משפחה</label>
						    </div>
						  </div><!-- .col -->
						  <div class="col-lg-12">
						    <button class="cont-submit btn-contact submit-btn tm-btn" type="submit" id="submit" name="submit">
							  <span>הוסף משתמש</span>
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