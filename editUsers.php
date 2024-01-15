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
					if($users['rank'] > 2){
						if(isset($_POST['submit'])){
							$id = safe($_POST['row']);
							$username = safe($_POST['username']);
							$email = safe($_POST['email']);
							$firstName = safe($_POST['firstName']);
							$lastName = safe($_POST['lastName']);
							$rank = safe($_POST['rank']);
							$passwordSafe = safeNoStrip($_POST['password']);
							$password = password($_POST['password']);
							$stmt1 = $db->query("SELECT * FROM `users` WHERE `id`='".$id."'");
							$stmt2 = $db->query("SELECT * FROM `ranks` WHERE `id`='".$rank."'");
							if($stmt1->num_rows == 0){
								echo error(".תקלה בעדכון המשתמש - המשתמש אינו קיים");
							}else if($users['rank'] <= $rank && $users['id'] != $id){
								echo error(".אין באפשרותך לערוך את דרגת המשתמש לדרגה שלך או מעלייך");
							}else if($users['id'] == $id && $rank > $users['rank']){
								echo error(".אין באפשרות להעלות את עצמך בדרגה");
							}else if(!preg_match('/[א-תA-Za-z]{3,50}/', $username)){
								echo error(".שם המשתמש חייב להכיל 3 עד 50 אותיות");
							}else if(!preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/', $email) || strlen($email) > 200){
								echo error(".המייל חייב להכיל נוסח של מייל");
							}else if(!preg_match('/[א-תA-Za-z]{2,50}/', $firstName)){
								echo error(".השם חייב להיות בין 2 עד 50 אותיות");
							}else if(!preg_match('/[א-תA-Za-z]{2,50}/', $lastName)){
								echo error(".שם המשפחה חייב להיות בין 2 עד 50 אותיות");
							}else if($stmt2->num_rows == 0){
								echo error(".הדרגה שהוזנה אינה אחת מהאופציות");
							}else{
								$userUpdate = $stmt1->fetch_assoc();
								if($users['rank'] <= $userUpdate['rank'] && $users['id'] != $id){
									echo error(".אין באפשרותך לערוך משתמש בדרגה שלך או מתחתיך");
								}else{
									if(strlen($passwordSafe) > 0){
										if(!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,200}/', $passwordSafe)){
											echo error(".הסיסמא חייבת להיות מעל ל8 תווים בעלת אותיות באנגלית, המכילה לפחות אות אחת גדולה וסיפרה");
										}else{
											$db->query("UPDATE `users` SET `username`='".$username."',`email`='".$email."',`password`='".$password."',`firstName`='".$firstName."',`lastName`='".$lastName."',`rank`='".$rank."' WHERE `id`='".$id."'");
											$email_message ="המשתמש שלך עודכן! \r\nפרטי המשתמש:\r\nשם משתמש: ".$username." \r\nסיסמא: ".$password." \n\r\nלהתחברות: http://sayaretzahanim.co.il\login.php";
											$to = $email;
											$subject = "עדכון משתמש באתר סיירת";
											$headers = "From: sayeretzanhanim@gmail.com\r\n";
											$headers .= "Reply-To: sayeretzanhanim@gmail.com\r\n";
											$headers .= "MIME-Version: 1.0\r\n";
											$headers .= "Content-Type: text/html; charset=utf-8\r\n";
											if(mail($to, $subject, $email_message, $headers)){
												echo success(".המשתמש עודכן ונשלח לו מייל עם פרטי המשתמש");
												echo "<script>setTimeout(function(){window.location.href = \"/newUser.php\";}, 1000);</script>";
											}else{
												echo error(".המשתמש עודכן, ונשלח לו מייל עם הפרטים");
												echo "<script>setTimeout(function(){window.location.href = \"/newUser.php\";}, 1000);</script>";	
											}
										}
									}else{
										$db->query("UPDATE `users` SET `username`='".$username."',`email`='".$email."',`firstName`='".$firstName."',`lastName`='".$lastName."',`rank`='".$rank."' WHERE `id`='".$id."'");
										echo success(".המשתמש עודכן בהצלחה");
									}
								}
							}
						}
					?>
					  <center><h1 style="color: white; background-color: #1C1C1C;">רשימת משתמשים</h1></center>
					  <?php
						$selectAllUsers = $db->query("SELECT * FROM `users`");
						if($selectAllUsers->num_rows > 0){
							while($row = $selectAllUsers->fetch_assoc()){
								$userRowRank = $db->query("SELECT * FROM `ranks` WHERE `id`='".$row['rank']."'");
								if($userRowRank->num_rows > 0){
									$userRank = $userRowRank->fetch_assoc();
									echo "<button type=\"button\" class=\"collapsible\"><div style=\"color: ".$userRank['color']."; float: right; margin-left: 10px;\">|&nbsp;".$userRank['name']."</div><div style=\"float: right\">".$row['firstName']." ".$row['lastName']."</div></button>
									<div style=\"display: none;\">
										<form action=\"\" class=\"row contact-form\" style=\"margin-top: 20px;\" method=\"post\">
											<input type=\"hidden\" id=\"row\" name=\"row\" value=\"".$row['id']."\">
											<div class=\"col-lg-6\">
												<div class=\"tm-form-field\">      
													<input type=\"text\" id=\"username\" name=\"username\" value=\"".$row['username']."\" required>
													<span class=\"bar\"></span>
													<label>שם משתמש</label>
												</div>
											</div><!-- .col -->
											<div class=\"col-lg-6\">
												<div class=\"tm-form-field\">      
													<input type=\"email\" id=\"email\" name=\"email\" value=\"".$row['email']."\" required>
													<span class=\"bar\"></span>
													<label>מייל</label>
												</div>
											</div><!-- .col -->
											<div class=\"col-lg-6\">
												<div class=\"tm-form-field\">      
													<input type=\"text\" id=\"firstName\" name=\"firstName\" value=\"".$row['firstName']."\" required>
													<span class=\"bar\"></span>
													<label>שם פרטי</label>
												</div>
											</div><!-- .col -->
											<div class=\"col-lg-6\">
												<div class=\"tm-form-field\">      
													<input type=\"text\" id=\"lastName\" name=\"lastName\" value=\"".$row['lastName']."\" required>
													<span class=\"bar\"></span>
													<label>שם משפחה</label>
												</div>
											</div><!-- .col -->
											<div class=\"col-lg-6\">
												<div class=\"tm-form-field\">      
													<input type=\"password\" id=\"password\" name=\"password\">
													<span class=\"bar\"></span>
													<label>עדכן סיסמה</label>
												</div>
											</div><!-- .col -->
											<div class=\"col-lg-6\">
												<div class=\"tm-form-field\">      
													<select id=\"rank\" name=\"rank\">";
														$stmt = $db->query("SELECT * FROM `ranks`");
														if($stmt->num_rows > 0){
															while($row2 = $stmt->fetch_assoc()){
																$selected = "";
																if($row2['id'] == $row['rank']){
																	$selected = "selected";
																}
																echo "<option value=\"".$row2['id']."\" ".$selected." style=\"text-align: center;\">".$row2['name']."</option>";
															}
														}
													echo "</select>
												</div>
											</div><!-- .col -->
											<div class=\"col-lg-12\">
												<button class=\"cont-submit btn-contact submit-btn tm-btn\" type=\"submit\" id=\"submit\" name=\"submit\">
													<span>עדכן משתמש</span>
												</button>
											</div>
										</form><!-- .row -->
									</div>";
								}
							}
						}else{
							echo "<button type=\"button\" class=\"collapsible\" style=\"text-align: center;\">!אין משתמשים</button>
								  <div class=\"content\">
									<p>.הוסף משתמש בכדי לערוך משתמשים</p>
								  </div>";
						}
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