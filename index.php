<?PHP
	include "header.php";
?>

  <!-- Start Hero Swiper Slider Section -->
  <section class="hero swiper-slider-1" id="home">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="slide-inner" data-swiper-parallax="45%">
            <div class="gradient-overlay"></div>
            <div class="swiper-bg-img"><img src="assets/img/hero-bg-02.jpg" alt=""></div>
            <div class="container">
              <div class="slider-text">
                <center><h1 style="color: white">סיירת צנחנים</h1>
                <span style="color: #ffffff; font-size: 1.5em"><i>"רק אלו שהלכו בחושך מבינים את יופיו של האור"</i></span></center>
              </div>
            </div>
          </div>
        </div><!-- .swiper-slide -->
        <div class="swiper-slide">
          <div class="slide-inner" data-swiper-parallax="45%">
            <div class="gradient-overlay"></div>
            <div class="swiper-bg-img"><img src="assets/img/hero-bg-03.jpg" alt=""></div>
            <div class="container">
              <div class="slider-text">
                <center><h1 style="color: white">סיירת צנחנים</h1>
                <span style="color: #ffffff; font-size: 1.5em"><i>"רק אלו שהלכו בחושך מבינים את יופיו של האור"</i></span></center>
              </div>
            </div>
          </div>
        </div><!-- .swiper-slide -->
        <div class="swiper-slide">
          <div class="slide-inner" data-swiper-parallax="45%">
            <div class="gradient-overlay"></div>
            <div class="swiper-bg-img"><img src="assets/img/hero-bg-01.jpg" alt=""></div>
            <div class="container">
              <div class="slider-text">
                <center><h1 style="color: white">סיירת צנחנים</h1>
                <span style="color: #ffffff; font-size: 1.5em"><i>"רק אלו שהלכו בחושך מבינים את יופיו של האור"</i></span></center>
              </div>
            </div>
          </div>
        </div><!-- .swiper-slide -->
      </div><!-- .swiper-wrapper -->
      <div class="swiper-controler">
        <div class="swiper-arrow">
          <div class="swiper-arrow-left"><i class="fa fa-caret-left"></i></div>
          <div class="swiper-arrow-right"><i class="fa fa-caret-right"></i></div>
        </div>
        <!-- Pagination -->
        <div class="expanded-timeline">
          <div class="swiper-slide-count"><span></span><span></span></div>
        </div>
      </div><!-- .swiper-controler -->
    </div>
  </section>
  <!-- End Hero Swiper Slider Section -->

  <!-- Start About Us Section -->
  <section class="about-us section" id="commander">
    <div class="container">
	  <center><h1 style="color: white; background-color: #1C1C1C;">איגרת מפקד</h1></center>
      <div class="testimonial-outer">
        <div class="testimonial-1 owl-carousel">
		<?php
			$selectLetters = $db->query("SELECT * FROM letter WHERE `status`='1'");
			if($selectLetters->num_rows != 0){
				while($letter = $selectLetters->fetch_assoc()){
					echo "<div class=\"single-testimonial\">
						<img src=\"".$letter['img']."\" alt=\"\" class=\"client-img\">
						<blockquote>
						  <i class=\"icofont icofont-quote-left\"></i>
						  ".$letter['message']."
						  <small>".$letter['rule']."<span>".$letter['sender']."</span></small>
						</blockquote>
					  </div><!-- .single-testimonial -->";
				}
			}
		?>
        </div>
      </div><!-- .testimonial-outer -->
    </div>
  </section>
  <!-- End About Us Section -->

  <div class="height-120"></div>
  
<?PHP
	include "footer.php";
?>