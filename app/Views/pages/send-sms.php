<?php $sess = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Send SMS</h2>
          <ol>
            <?php if ($sess->loginId) { ?>
                <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
                <li><a href="<?php echo base_url();?>/sms-details">SMS</a></li>
            <?php } ?>
            <li>Send SMS</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <form class="row g-3 php-email-form" method="post" id="createUser">
                <div class="col-md-12">
                    <label for="client" class="form-label">Select Client</label>
                    <select id="client" name="client" class="form-select" onChange="return selectClient(this.value);">
                        <option value="">Choose...</option>
                        <?php if (isset($clients) && !empty($clients)) { foreach($clients as $ckey => $cval) {  ?>
                          <option value="<?php echo $cval['customer_id'].'##'.$cval['customer_name'].'##'.$cval['contact_number']?>"><?php echo $cval['customer_name'];?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="client_name" class="form-label">Client Name</label>
                    <input type="text" name="client_name" class="form-control" id="client_name" value="">
                </div>
                <div class="col-6">
                    <label for="client_phone" class="form-label">Phone Number</label>
                    <input type="text" name="client_phone" class="form-control" id="client_phone" placeholder="" value="">
                </div>
                <div class="col-md-12">
                    <label for="sms" class="form-label">SMS</label>
                    <textarea class="form-control" id="sms"  name="sms" aria-label="With textarea"></textarea>
                </div>
                
                
                <div class="my-2">
                    <input type="hidden" id="login_id" name="login_id" value="<?php echo isset($sess)?$sess->loginId:'';?>">
                    <input type="hidden" id="client_id" name="client_id" value="">
                    <div class="loading" id="loading">Loading</div>
                    <div class="error-message" id="error-message"></div>
                    <div class="sent-message" id="success-message"></div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </section>
</main>


<script type="text/javascript">
  const selectClient = (val) => {
    // console.log(val);
    const data = val.split('##');
    // console.log(clientId, clientName, clientPhone, val.split('##'));
    $('#client_id').val(data[0]);
    $('#client_name').val(data[1]);
    $('#client_phone').val(data[2]);
  }
  $(document).ready(() => {
    $('#createUser').validate({
      rules: {
        phone_number: {
            required: true,
            digits: true,
        },
        sms: {
            required: true,
        },
      },
      submitHandler: function() { 
        const formData = {
          'client_id': $('#client_id').val(),
          'client_name' : $('#client_name').val(),
          'client_phone': $('#client_phone').val(),
          'sms' : $('#sms').val(),
          'login_id' : $('#login_id').val(),
        }
        $('#loading').show();
        $('#success-message').hide();
        $('#error-message').hide();
        $.ajax({
          url:"<?php echo base_url('send-sms');?>",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          if (response.status == 200) {
            $('#success-message').html(response.message).show();
            if (response.redirectUrl) {
              // window.location.href = response.redirectUrl;
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