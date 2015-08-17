<?php defined('WPSS_PATH') or die();?>
  <?php $quizzes = new WPSS_Quiz();?>
  <?php $util = new WPSS_Util();?>

<?php

global $wpdb;

$wpdb->insert( 
  'wp_wpss_quizzes_30', 
  array( 
    'store_results' => 1, 
    'send_admin_email' => 1,
    'send_user_email' =>  1,
    'show_title' =>  1,
  ), 
  array( 
    '%d', 
    '%d',
    '%d',
    '%d'

  ) 
);

echo $wpdb->insert_id;

//header('Location: '. $util->admin_url('quiz', 'edit', $wpdb->insert_id) . '');


?>


<?php $quiz = new WPSS_Quiz((int) $wpdb->insert_id);?>

<!-- Admin quizzes#edit -->
<div class="wrap wpss">
  <img class="left" src="<?php echo WPSS_URL.'assets/images/wpss_admin.png'?>" />
  <h2 class="left"><?php echo $quiz->title;?> </h2>
  <div class="clear"></div>
  <hr />

  <p class="wpss-breadcrumb">
    <a href="<?php echo $util->admin_url('','','');?>">Quizzes</a> &raquo; 
    <a class="current" href=""><?php echo $quiz->title;?></a>
    (<a href="<?php echo $util->admin_url('quiz', 'questions_index', $quiz->id);?>">Questions</a>, 
    <a href="<?php echo $util->admin_url('quiz', 'fields_index', $quiz->id);?>">Fields</a>, 
    <a href="<?php echo $util->admin_url('quiz', 'routes_index', $quiz->id);?>">Routes</a>)
  </p>


  <?php include( WPSS_PATH . "admin/quizzes/_formAdd.php");?>

</div>
