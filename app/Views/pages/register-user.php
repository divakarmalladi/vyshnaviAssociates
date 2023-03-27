<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $pageName;?></h2>
          <ol>
            <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
            <?php if ($userPath != 'edit-profile') { ?>
            <li><a href="<?php echo base_url();?>/users">Users</a></li>
            <?php } ?>
            <li><?php echo $pageName;?></li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <form class="row g-3 php-email-form" method="post" id="createUser">
                <div class="col-md-6">
                    <label for="user_name" class="form-label">User Name</label>
                    <input type="text" name="user_name" class="form-control" id="user_name" value="<?php echo isset($userData) ? $userData->user_name:'';?>">
                </div>
                <div class="col-md-6">
                    <label for="user_email" class="form-label">Email</label>
                    <input type="text" name="user_email" class="form-control" id="user_email" value="<?php echo isset($userData) ? $userData->user_email:'';?>">
                </div>
                <div class="col-md-6">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" name="user_password" class="form-control" id="user_password" value="<?php echo isset($userData) ? $userData->user_password:'';?>">
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" value="<?php echo isset($userData) ? $userData->confirm_password:'';?>">
                </div>
                <div class="col-6">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="" value="<?php echo isset($userData) ? $userData->phone_number:'';?>">
                </div>
                <div class="col-md-6">
                    <label for="user_type" class="form-label">User Type</label>
                    <select id="user_type" name="user_type" class="form-select">
                        <option value="">Choose...</option>
                        <option value="1" <?php echo isset($userData) && $userData->user_type == '1'? 'selected':'';?>>Admin</option>
                        <option value="2" <?php echo isset($userData) && $userData->user_type == '2'? 'selected':'';?>>Assistant</option>
                        <option value="3" <?php echo isset($userData) && $userData->user_type == '3'? 'selected':'';?>>Employee</option>
                    </select>
                </div>
                <div class="my-2">
                    <input type="hidden" id="login_id" name="login_id" value="<?php echo isset($userData)?$userData->login_id:'';?>">
                    <div class="loading" id="loading">Loading</div>
                    <div class="error-message" id="error-message"></div>
                    <div class="sent-message" id="success-message"></div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><?php echo isset($userData)?'Update':'Save';?></button>
                </div>
            </form>
        </div>
    </section>
</main>