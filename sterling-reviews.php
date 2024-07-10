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
  $data = $json['reviews'];

  $image = ""; $slides = ""; $count = 0;

  for ($i=0; $count < 10 ; $i++) { 
      $random = (int)rand(0, sizeof($data));
      
      if($data[$random]['starRating']!=="FIVE" || !array_key_exists("comment",$data[$random])) continue;
  
  $slides .= '<div class="slide">
  <p class="description elementor-heading-title">
    '.$data[$random]["comment"].'
  </p>
  <div class="name">
  '.$data[$random]["reviewer"]["displayName"].'
  </div>
  <div class="ratings">
  <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>'; 
$count ++;
}
    return '
    <div class="testimonials">
    <div class="row">
      <div class="col-40">
        <div class="person-slider">
          <div class="person-slides">
          <div class="person-slide slide-0">
    <img src="https://sterlingwpcobra.s3.us-west-1.amazonaws.com/wp-content/uploads/2023/05/09091439/quotes-face-5.png" alt="Sterling Google Reviews">
  </div>
          <div class="person-slide slide-1">
    <img src="https://sterlingwpcobra.s3.us-west-1.amazonaws.com/wp-content/uploads/2023/05/09091441/quotes-face-4.png" alt="Sterling Google Reviews">
  </div>
          <div class="person-slide slide-2">
    <img src="https://sterlingwpcobra.s3.us-west-1.amazonaws.com/wp-content/uploads/2023/05/09091441/quotes-face-3.png" alt="Sterling Google Reviews">
  </div>
          <div class="person-slide slide-3">
    <img src="https://sterlingwpcobra.s3.us-west-1.amazonaws.com/wp-content/uploads/2023/05/09091441/quotes-face-1.png" alt="Sterling Google Reviews">
  </div>
          <div class="person-slide slide-4">
    <img src="https://sterlingwpcobra.s3.us-west-1.amazonaws.com/wp-content/uploads/2023/05/09091443/quotes-face-2.png" alt="Sterling Google Reviews">
  </div>
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