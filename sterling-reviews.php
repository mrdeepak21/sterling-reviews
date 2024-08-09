<?php
/**
 * @version 2.0.0 @package sterling-reviews
 * Plugin Name: Google Reviews by Heigh10
 * Version: 2.0
 * Author: Heigh10.com
 * Author URI: https://heigh10.com
 * Description: Google reviews Showcase, using json file & cobra_testimonials post_type. Use shortcode [google_reviews_sterling] to display anywhere
 */

 add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'testimonials', plugins_url( '/front-end/style.css' , __FILE__ ), false, '1.0', 'all');
    wp_enqueue_script('gsap',"https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js", false,'1.0',true);
    wp_enqueue_script('motionpath-plugin-gsap',"https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/MotionPathPlugin.min.js", false,'1.0',true);
    wp_enqueue_script('testimonials',plugins_url( '/front-end/script.js', __FILE__ ), array('jquery'),'1.0',true);
    wp_enqueue_style( 'font-awesome-6.4', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',false,'6.4','all');
} );

add_shortcode( 'google_reviews_sterling', function()
{
  $str = file_get_contents(plugins_url( '/reviews.json', __FILE__ ));
  $json = json_decode($str, true); 
  $data = $json['reviews'];
  $arr = [];
  $slides = "";

  for ($i=0; sizeof($arr) < 10 ; $i++) { 
      $extra_class = sizeof($arr)===0?"active":"";
      $random = rand(0,sizeof($data)-1);
    if($data[$random]['starRating']!=="FIVE" || !array_key_exists("comment",$data[$random]) || in_array($random,$arr)) continue;
    array_push($arr,$random);
  $slides .= '
  <div class="testimonial '.$extra_class.'">
                    <div class="review">
                       '.$data[$random]["comment"].'
                    </div>
                    <div class="name">
                        '.$data[$random]["reviewer"]["displayName"].' | Google
                    </div>
                    <div class="ratings">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>'; 
}
    return '
    <div class="g-reviews" id="g-reviews">
    <div class="google-row">
        <div class="google-col-1">
            <div class="left">
            <div class="nav-container" style="text-align: center;">
                <button id="prev" class="nav">&#8592;</button>
                <button id="next" class="nav">&#8594;</button>
                <span class="number" id="number"></span>
              </div>
            <div class="wrapper">
                <div class="dots"></div>
                <svg viewBox="0 0 3200 3200" id="viewBox">
                  <circle id="holder" class="circle" cx="1600" cy="1600" r="800"/>
                </svg>
              </div>
            </div>
        </div>
        <div class="google-col-2">
            <div class="content-wrapper" id="content">                
                '.$slides.'
            </div>
        </div>
    </div>
</div>
      ';
});