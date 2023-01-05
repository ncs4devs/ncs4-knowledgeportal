<?php 
// enqueue the JavaScript file
wp_enqueue_script( 'custom-post-script', plugin_dir_url( __FILE__ ) . '/js/script.js' );
wp_enqueue_style( 'custom-post-style', plugin_dir_url( __FILE__ ) . '/css/index.css' );

$templates = new KP_Template_Loader; 
?>
<div>

  <div class="kp-dashboard-main-buttons-container">
    <div class="kp-dashboard-main-button" id='kp-search-button'>
      <i class="dashicons dashicons-search kp-search-icon"></i>
      <input type="text" placeholder="Search for Entries" id='kp-search-input'>
    </div>
    <div class="kp-dashboard-main-button" id='kp-contribute-button'>
      Contribute to the Knowledge Portal
    </div>
  </div>

  <div id="kp-dashboard-entries-loop">
    <?php 
    $templates->get_template_part( 'entries-loop' );
    ?>
  </div>

  <div id='kp-contribution-form'>

  </div>
</div>
