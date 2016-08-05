 <div class="row">
 <div class="col-md-3 centerMe">
  <div class="thumbnail">
    <div class="row">
      <div class="col-md-12 form-main">
        <div id="infoMessage"><?php echo $message;?></div>
        <h1 class="login-heading"><?php echo lang('login_heading');?></h1>
        <h5><?php echo lang('login_subheading');?></h5>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 form-main">
        <?php echo form_open("auth/login");?>
          <div class="form-group">
              <?php echo lang('login_identity_label', 'identity');?>
              <?php echo form_input($identity);?>
          </div>

          <div class="form-group">
              <?php echo lang('login_password_label', 'password');?>
              <?php echo form_input($password);?>
          </div>

          <div class="form-group">
              <?php echo lang('login_remember_label', 'remember');?>
              <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
          </div>
          <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>
        <?php echo form_close();?>
      </div>
    </div>

    <p><a href="forgot_password" class="form-main"><?php echo lang('login_forgot_password');?></a></p>
  </div>
  </div>
</div>