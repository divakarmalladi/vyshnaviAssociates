<?php $userType = explode('-', $userPath)[0];?>
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $pageName ? $pageName: 'Admin Login';?></h2>
          <ol>
            <li><a href="index.html">Home</a></li>
            <li><?php echo $pageName ? $pageName: 'Admin Login';?></li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
      <div class="container">
        
        <form method="post" id="loginForm" role="form" class="php-email-form mt-4">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12 form-group">
                  <input type="text" name="login_id" class="form-control" id="login_id" placeholder="Your User ID" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group mt-3 mt-md-0">
                  <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Your Password" required>
                </div>
              </div>
              <div class="my-2">
                <input type="hidden" name="user_type" class="form-control" id="user_type" value="<?php echo $userType; ?>">
                <div class="loading" id="loading">Loading</div>
                <div class="error-message" id="error-message"></div>
                <div class="sent-message" id="success-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-left"><button type="submit">Login</button></div>
            </div>
            <?php if ($userType == 'employees') {?>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-8 form-group cardParent">
                  <div class="card">
                    <div class="card-body">
                      <!-- <h5 class="card-title">Special title treatment</h5> -->
                      <p class="card-text">Don't have an account to login?</p>
                      <a href="<?php echo base_url('register/'.$userType)?>" class="btn btn-primary">Click here to register</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          
        </form>
      </div>
    </section>

  </main><!-- End #main -->
<script type="text/javascript">
  $(document).ready(() => {
    $('#loginForm').validate({
      rules: {
        login_id: {
              required: true,
          },
          user_password: {
              required: true,
          }
      },
      submitHandler: function() { 
        const formData = {
          'login_id': $('#login_id').val(),
          'user_password' : $('#user_password').val(),
          'user_type' : $('#user_type').val(),
        }
        $('#loading').show();
        $('#success-message').hide();
        $('#error-message').hide();
        $.ajax({
          url:"<?php echo base_url();?>/user-login",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          if (response.status == 200) {
            $('#success-message').html(response.message).show();
            window.location.href = '<?php echo base_url();?>/user-dashboard';
          } else if (response.status == 201) {
            $('#error-message').html('Invalid Logins').show();
          } else {
            $('#error-message').html('Something went wrong, Please try agains').show();
          }
          $('#loading').hide();
        }).fail(function( jqXHR, textStatus ) {
          $('#error-message').html('Something went wrong, Please try again');
          $('#loading').hide();
        });
      }
    });
  })
</script>
