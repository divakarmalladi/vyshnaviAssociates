<?php $sess = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Dashboard</h2>
          <ol>
            <li><a href="index.html">Home</a></li>
            <li>Dashboard</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-tile-green text-white mb-4">
                    <div class="card-body">Clients</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="bx bxs-group f-70"></i>
                        <a class="small text-white stretched-link" href="<?php echo base_url();?>/clients">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <?php if (isset($sess->userData['user_type']) && $sess->userData['user_type'] == 2) { ?>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-tile-blue text-white mb-4">
                    <div class="card-body">Client Registration</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="bx bx-file f-70"></i>
                        <a class="small text-white stretched-link" href="<?php echo base_url();?>/client-registration">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (isset($sess->userData['user_type']) && $sess->userData['user_type'] == 1) { ?>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-tile-success text-white mb-4">
                    <div class="card-body">Users</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="bx bx-user f-70"></i>
                        <a class="small text-white stretched-link" href="<?php echo base_url();?>/users">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (isset($sess->userData['user_type']) && $sess->userData['user_type'] != 3) { ?>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-tile-success text-white mb-4" style="background-color: #00342e;">
                    <div class="card-body">Send SMS</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="bx bx-message f-70"></i>
                        <a class="small text-white stretched-link" href="<?php echo base_url();?>/sms-details">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (isset($sess->userData['user_type']) && $sess->userData['user_type'] != 3) { ?>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-tile-success text-white mb-4" style="background-color: #15766b;">
                    <div class="card-body">Notifications</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="bx bx-bell f-70"></i>
                        <a class="small text-white stretched-link" href="<?php echo base_url();?>/notifications">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Profile</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="bx bxs-lock f-70"></i>
                        <a class="small text-white stretched-link" href="<?php echo base_url();?>/edit-profile/<?php echo $sess->loginId;?>">Edit Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</main>