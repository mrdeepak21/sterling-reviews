<?php
/**
 * @version 1.0.0 @package sterling-reviews
 * Plugin Name: Google Reviews by Heigh10
 * Author: Heigh10.com
 * Author URI: https://heigh10.com
 * Description: Google reviews Showcase, using json file & cobra_testimonials post_type. Use shortcode [google_reviews_sterling] to display anywhere
 */

 add_action( 'wp_enqueue_scripts', function () {
  wp_enqueue_style( 'testimonials', plugins_url( '/front-end/style.css' , __FILE__ ), false, '1.0', 'all');
  wp_enqueue_style( 'font-awesome-6.4', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',false,'6.4','all');
  if(is_front_page()) {
  wp_enqueue_script('testimonials',plugins_url( '/front-end/script.js', __FILE__ ), false,'1.0', true );}
} );

add_shortcode( 'google_reviews_sterling', function()
{
  $str = file_get_contents(plugins_url( '/reviews.json', __FILE__ ));
  $json = json_decode($str, true); 

  $image = ""; $slides = "";$count = 1;$slide_no = 0;
  foreach ($json['reviews'] as $key => $value) {
    if($count===6) break;
    if($value['starRating']!=='FIVE') continue;
 
    $image .= '<div class="person-slide slide-'.$slide_no.'">
    <img src="https://dummyimage.com/200x200/000/fff.jpg" alt="'.$value["reviewer"]["displayName"].'">
  </div>';
  
  $slides .= '<div class="slide">
  <p class="description elementor-heading-title">
    '.$value["comment"].'
  </p>
  <div class="name">
  '.$value["reviewer"]["displayName"].'
  </div>
  <div class="ratings">
  <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>'; 
  $count++;$slide_no++;
}
    return '
    <div class="testimonials">
    <div class="row">
      <div class="col-40">
        <div class="person-slider">
          <div class="person-slides">
          '.$image.'
          </div>
        </div>
      </div>
      <div class="col-60">
        <div class="slider">
          <div class="slides">
            '.$slides.'                     
        </div>
        <div class="dots"></div>
      </div>
    </div>
    </div>
      ';
});