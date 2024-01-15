<?PHP
	include "header.php";
	if(!isset($_COOKIE['uid'])){
	?>
	  <div class="height-70"></div>
	  <!-- Start Login Form -->
	  <section class="contact-wrap section" id="contact">
		<div class="container">
		  <div class="section-head text-center">
			  <h2>התחברות</h2>
			  <div class="section-divider">
				<div class="left wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s"></div>
				<span></span>
				<div class="right wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s"></div>
			  </div>
		  </div>
		  <?php
			if(isset($_POST['submit'])){
				$username = safe($_POST['username']);
				$password = password($_POST['password']);
				$loginstmt = $db->query("SELECT * FROM `users` WHERE (`email`='".$username."' OR `username`='".$username."') AND `password`='".$password."'");
				if($loginstmt->num_rows == 0){
					echo error("!שם המשתמש או הסיסמה אינם נכונים");
				}else{
					$loginfetch = $loginstmt->fetch_assoc();
					setcookie('uid', $loginfetch['id'], time() + (86400 * 30), "/");
					echo success("!התחברת בהצלחה");
					echo "<script>setTimeout(function(){window.location.href = \"/index.php\";}, 2000);</script>";
				}
			}
		  ?>
		  <form action="" class="row contact-form" method="post">
			<div class="col-lg-6">
			  <div class="tm-form-field">      
				<input type="text" id="username" name="username" required>
				<span class="bar"></span>
				<label>שם משתמש / מייל</label>
			  </div>
			</div><!-- .col -->
			<div class="col-lg-6">
			  <div class="tm-form-field">      
				  <input type="password" id="password" name="password" required>
				  <span class="bar"></span>
				  <label>סיסמה</label>
			  </div>
			</div>
			<div class="col-lg-12">
				<button class="cont-submit btn-contact submit-btn tm-btn" type="submit" id="submit" name="submit">
				  <span>התחבר</span>
				</button>
			</div>
			<div class="col-lg-12">
				<a style="color: white" href="/register.php"><button class="cont-submit btn-contact submit-btn tm-btn" type="button" style="background-color: red;" name="submit">
				  <span>הרשמה</span></a>
				</button>
			</div>
		  </form><!-- .row -->
		</div>
	  </section>
	  <!-- End Login Form -->
	  
	  <div class="height-120"></div>

	<?php
	}else{
	?>
	  <section class="contact-wrap section" id="contact">
		<div class="container">
		  <div class="section-head text-center">
			  <h2>התנתקות</h2>
			  <div class="section-divider">
				<div class="left wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s"></div>
				<span></span>
				<div class="right wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s"></div>
			  </div>
		  </div>
	<?php
		echo success("!התנתקת בהצלחה");
	?>
		</div>
	  </section>
	  <div class="height-120"></div>
	<?php
		unset($_COOKIE['uid']); 
		setcookie('uid', null, -1, '/');
		echo "<script>setTimeout(function(){window.location.href = \"/login.php\";}, 1000);</script>";
	}
	include "footer.php";
?>
