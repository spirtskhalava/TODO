<?php require APP_ROOT . '/views/inc/header.php' ?>
<?php flash('post_message'); ?>
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Tasks</h1>
        </div>
          <form class="pull-right" action="<?php echo URL_ROOT; ?>/posts/sort" method="post">
<input type="submit" value="sort by user" class="btn btn-danger">
</form>
  <form class="pull-right" action="<?php echo URL_ROOT; ?>/posts/sortbyemail" method="post">
<input type="submit" value="sort by email" class="btn btn-danger">
</form>
  <form class="pull-right" action="<?php echo URL_ROOT; ?>/posts/sortbystatus" method="post">
<input type="submit" value="sort by email" class="btn btn-danger">
</form>
        <div class="col-md-6">
          <?php if(isset($_SESSION['user_id'])){?>  <a href="<?php echo URL_ROOT; ?>/posts/add" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Add Post
            </a><?php }?>
        </div>
    </div>
     <div class="col-md-6">
            </div>
<?php foreach($data['posts'] as $post) : ?>
<div class="card card-body mb-3">
    <div class="card-block">
    <h4 class="card-title"><?php echo $post->email; ?></h4>
    <h6 class="card-subtitle mb-2 text-muted">Author <?php echo $post->name; ?> on <?php echo helper_format_date($post->created_at);?></h6>
    <p class="card-text breakline"><?php echo $post->body; ?></p>
    <p class="card-text">
    <?php
    if($post->status=="completed"){
        echo "Status:completed";
    }elseif($post->status=="edited by the administrator"){
        echo "Status:edited by the administrator";
    }
    ?>
    </p>
<?php if(isset($_SESSION['user_id']) && $_SESSION['user_role']=='admin'){?><a href="<?php echo URL_ROOT; ?>/posts/show/<?php echo $post->post_id; ?>" class="btn btn-dark">More</a><?php }?>
    </div>
</div>
<?php endforeach; ?>
<?php

require '../vendor/autoload.php';

use JasonGrimes\Paginator;

$totalItems = 20;
$itemsPerPage = 2;
$currentPage = 1;
$urlPattern = '/pages/index/(:num)';

$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
  echo $paginator;
?>
<?php require APP_ROOT . '/views/inc/footer.php' ?>