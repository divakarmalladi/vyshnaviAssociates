<?php $sess = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $sess->loginId ? $pageName : $pageName. ' as '.ucwords($userType);?></h2>
          <ol>
            <?php if ($sess->loginId) { ?>
                <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
                <?php if ($userPath != 'edit-profile') { ?>
                <li><a href="<?php echo base_url();?>/users">Users</a></li>
            <?php } } else { ?>
                <li><a href="<?php echo base_url();?>">Home</a></li>
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
                    <input type="text" name="user_name" class="form-control" id="user_name" value="<?php echo isset($userData) ? $userData->user_name:'';?>" <?php echo $sess->userData && $sess->userData['user_type'] != 1? 'disabled':'';?>>
                </div>
                <div class="col-md-6">
                    <label for="user_email" class="form-label">Email</label>
                    <input type="text" name="user_email" class="form-control" id="user_email" value="<?php echo isset($userData) ? $userData->user_email:'';?>" <?php echo $sess->userData && $sess->userData['user_type'] != 1? 'disabled':'';?>>
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
                    <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="" value="<?php echo isset($userData) ? $userData->phone_number:'';?>" <?php echo $sess->userData && $sess->userData['user_type'] != 1? 'disabled':'';?>>
                </div>
                <div class="col-md-6">
                    <?php if ($sess->loginId && ($sess->userData && $sess->userData['user_type'] == 1)) { ?>
                    <label for="user_type" class="form-label">User Type</label>
                    <select id="user_type" name="user_type" class="form-select">
                        <option value="">Choose...</option>
                        <option value="1" <?php echo isset($userData) && $userData->user_type == '1'? 'selected':'';?>>Admin</option>
                        <option value="2" <?php echo isset($userData) && $userData->user_type == '2'? 'selected':'';?>>Assistant</option>
                        <option value="3" <?php echo isset($userData) && $userData->user_type == '3'? 'selected':'';?>>Employee</option>
                    </select>
                    <?php } else { ?>
                        <input type="hidden" name="user_type" id="user_type" value="<?php echo $sess->loginId ? $sess->userData['user_type']: USER_TYPES[$userType]?>">
                    <?php } ?>
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

<!-- Modal -->
<div class="modal fade" id="loginIdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please use below login id for Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 id="logLoginId"></h3>
        <a href="<?php echo base_url((isset($userType)?$userType.'-login':'admin-login'));?>" class="btn btn-primary" >Click here to login</a>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(() => {
    $('#createUser').validate({
      rules: {
        user_name: {
              required: true,
        },
        user_email: {
            required: true,
            email: true
        },
        user_password: {
            required: true,
            minlength: 6,
            maxlength: 15,
        },
        confirm_password: {
            required: true,
            equalTo: user_password,
        },
        phone_number: {
            required: true,
            digits: true,
        },
        user_type: {
            required: true,
        },
      },
      submitHandler: function() { 
        const formData = {
          'user_name': $('#user_name').val(),
          'user_email' : $('#user_email').val(),
          'user_password': $('#user_password').val(),
          'confirm_password' : $('#confirm_password').val(),
          'phone_number': $('#phone_number').val(),
          'user_type' : $('#user_type').val(),
          'login_id' : $('#login_id').val(),
        }
        $('#loading').show();
        $('#success-message').hide();
        $('#error-message').hide();
        $.ajax({
          url:"<?php echo base_url((isset($ajaxUrl)?$ajaxUrl:''));?>",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          if (response.status == 200) {
            $('#success-message').html(response.message).show();
            if (response.redirectUrl) {
              window.location.href = response.redirectUrl;
            }
            if (response.page == 'home') {
              $('#createUser')[0].reset();
              $('#logLoginId').html(response.loginId);
              var myModal = new bootstrap.Modal(document.getElementById('loginIdModal'), {
                keyboard: false
              })
              myModal.show()
            }
          } else if (response.status == 201) {
            let msg = '';
            for (const error in response.errors) {
              msg = msg + response.errors[error] + '<br>';
            }
            $('#error-message').html(msg).show();
          } else {
            $('#error-message').html('Something went wrong, Please try again').show();
          }
          $('#loading').hide();
        }).fail(function( jqXHR, textStatus ) {
          $('#error-message').html('Something went wrong, Please try again').show();
          $('#loading').hide();
        });
      }
    });
  })
</script>