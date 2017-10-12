<!-- <h1>< php echo lang('create_user_heading'); ></h1>--> 
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>
<input type="hidden" id="mode" name="mode" value="<?php echo $mode;?>" />
      <?php
      if($show_first_name) { ?>
      <p>
            <?php echo lang('create_user_fname_label', 'first_name');  ?> <br />
            <?php echo form_input($first_name); ?>
      </p>
	  <?php
	  }
	  if($show_last_name) {
	  ?>
      <p>
            <?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
            <?php echo form_input($last_name); ?>
      </p>
	  <?php
	  } 
	  ?>
      <?php
      if($identity_column!=='email' || $show_username) {
          echo '<p>';
          echo lang('create_user_identity_label', 'identity');
          echo '<br />';
          echo form_error('identity');
          echo form_input($identity);
          echo '</p>';
      }
      ?>
	  <?php
	  if($show_company) {
	  ?>
      <p>
            <?php echo lang('create_user_company_label', 'company'); ?> <br />
            <?php echo form_input($company); ?>
      </p>
	  <?php
	  } 
	  ?>
      <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email);?>
      </p>
	  <?php
	  if($show_phone) {
	  ?>
      <p>
            <?php echo lang('create_user_phone_label', 'phone'); ?> <br />
            <?php echo form_input($phone); ?>
      </p>
	  <?php
	  } 
	  ?>
      <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close();?>
