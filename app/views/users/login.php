<?php require APP_ROOT . '/views/inc/header.php' ?>
<div class="row">
<div class="col-md-6 mx-auto">
  <div class="card card-body bg-light mt-5">
      <?php flash('register_success'); ?>
     <h3>Login</h3>
     <form action="<?php echo URL_ROOT; ?>/users/login" method="post">
        <div class="form-group">
           <label for="name">Username: <sup>*</sup></label>
           <input type="text" name="user" class="form-control form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['user']; ?>">
           <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
        </div>
        <div class="form-group">
           <label for="name">Password: <sup>*</sup></label>
           <input type="password" name="password" class="form-control form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['password']; ?>">
           <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
        </div>
        <div class="row">
           <div class="col">
              <input type="submit" value="Login" class="btn btn-success btn-block"/>
           </div>
           <div class="col">
              <a href="<?php echo URL_ROOT; ?>/users/register" class="btn btn-light btn-block">Register</a>
           </div>
        </div>
     </form>
  </div>
</div>
<?php require APP_ROOT . '/views/inc/footer.php' ?>