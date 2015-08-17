<?php defined('WPSS_PATH') or die();?>

<?php $util = new WPSS_Util();?>
<?php $question = new WPSS_Question((int) $_GET['id']);?>
<?php $quiz = new WPSS_Quiz($question->quiz_id);?>

<?php



use phpforms\Form;
use phpforms\Validator\Validator;

//session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpforms/Form.php';
/* =============================================
    validation if posted
============================================= */

global $wpdb;


     $protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $port      = $_SERVER['SERVER_PORT'];
        $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
        $domain    = $_SERVER['SERVER_NAME'];
        $full_url  = "${protocol}://${domain}${disp_port}"; # Ex: 'http://example.com', 'https://example.com/mywebsite', etc.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/phpforms/Validator/Validator.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/phpforms/Validator/Exception.php';


    $validator = new Validator($_POST);
    


//         echo  $full_url . '/file-uploads/' . $_POST['cv'][0];



$wpdb->update( 
	
	'test_wpss_questions_30', 
	array( 
		'img_url' => $_POST['cv'][0]	// string
	), 
	array( 'ID' => $question->id ), 
	array( 
		'%s',	// value1
	), 
	array( '%d' ) 
);





    
}

/* ==================================================
    The Form

    for class and methods documentation,
    go to documentation/index.html
================================================== */

$form = new Form('cv-submission-form', 'horizontal', 'novalidate=true');
$options = array(
     
        'horizontalElementCol'     => 'col-sm-12',
);
$form->setOptions($options);

$fileUpload_config = array(
'xml'                 => 'default',
'uploader'            => 'defaultFileUpload.php',
'btn-text'            => 'Browse ...',
'max-number-of-files' => 1
);

$form->setOptions($options);
$form->addHtml('<span class="help-block">Accepted File Types : .jpeg, .png, .gif</span>', 'cv[]', 'after');
$form->addFileUpload('file', 'cv[]', '', '', 'id=cvFileUpload', $fileUpload_config);
$form->addBtn('submit', 'submit-btn', 1, 'Upload image', 'class=btn button-primary');
$form->endFieldset();


?>

<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/phpforms/plugins/jQuery-File-Upload/css/jquery.fileupload.css" rel="stylesheet" media="screen">

   

<!-- Admin questions#new -->
<div class="wrap wpss">
  <img class="left" src="<?php echo WPSS_URL.'assets/images/wpss_admin.png'?>" />
  <h2 class="left"><?php echo $quiz->title;?>, Editing Question</h2>
  <div class="clear"></div>
  <hr />

  <p class="wpss-breadcrumb">
    <a href="<?php echo $util->admin_url('','','');?>">Quizzes</a> &raquo; <a href="<?php echo $util->admin_url('quiz', 'edit', $quiz->id);?>"><?php echo $quiz->title;?></a> &raquo; <a href="<?php echo $util->admin_url('quiz', 'questions_index', $quiz->id);?>">Questions</a> &raquo; <a class="current">Edit</a>
  </p>
 <div class="container" style="padding: 20px 5px;">


        <div class="row">
            <div class="col-sm-8 col-md-8">
            <?php
            if (isset($_POST['cv'][0])) {
				echo '<p class="alert alert-success">Image has been uploaded !</p>';
				echo '<img src="'. $full_url . '/file-uploads/medium/' . $_POST['cv'][0] .'" /><br/><br/>'; 
				
            }else{
            	$sql = "SELECT * FROM test_wpss_questions_30 WHERE id = ". $question->id . "";
       
            $mylink = $wpdb->get_results($sql); 
            echo '<img src="'. $full_url . '/file-uploads/medium/' . $mylink[0]->img_url .'" /><br/><br/>'; 
            }
            ?>


            <?php 
            
            //print_r($mylink);
            ?>
          
            <?php
           	 $form->render();
            ?>
            </div>
        </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <?php
            $form->printIncludes('js');
            $form->printJsCode();
        ?>
    </div>
  <?php include( WPSS_PATH . "admin/questions/_form.php");?>

</div>
