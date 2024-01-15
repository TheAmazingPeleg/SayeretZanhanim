<?php
	include "header.php";
	if(isset($_COOKIE['uid'])){
		if($users['status'] == 0){
?>
	<div class="height-70"></div>
    <!-- Start Site Content -->
    <div class="blog-site-content blog-section blog-left-sidebar">
        <div class="container">
            <div class="row">
                <main class="col-xl-9 col-lg-8 site-main">
				  <section class="about-us section" id="commander">
				  <h3>!עלייך להמתין לאישורך במערכת על ידי ההנהלה</h3>
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