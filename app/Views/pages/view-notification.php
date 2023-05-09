<?php $session = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>View Notification</h2>
          <ol>
            <li><a href="<?php echo base_url();?>/dashboard">Dashboard</a></li>
            <li><a href="<?php echo base_url();?>/notifications">Notifications</a></li>
            <li>View Notification</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Notification</th>
                                <td scope="col"><?php echo isset($notification[0])?$notification[0]['activity_title']:''?></td>
                            </tr>
                            <tr>
                                <th scope="col">Description</th>
                                <td scope="col"><?php echo isset($notification[0])?$notification[0]['activity_description']:''?></td>
                            </tr>
                            <tr>
                                <th scope="col">Employee Name</th>
                                <td scope="col"><?php echo isset($notification[0])?$notification[0]['user_name']:''?></td>
                            </tr>
                            <tr>
                                <th scope="col">Date</th>
                                <td scope="col"><?php echo isset($notification[0])?date('d-m-Y, h:i a', strtotime($notification[0]['created_date'])):''?></td>
                            </tr>
                            <tr>
                                <th scope="col">Client Name</th>
                                <td scope="col"><?php echo isset($notification[0])?$notification[0]['customer_name']:''?></td>
                            </tr>
                            <tr>
                                <th scope="col">Client Id</th>
                                <td scope="col"><?php echo isset($notification[0])?$notification[0]['client_id']:''?></td>
                            </tr>
                            <?php if (isset($notification[0]) && $notification[0]['page_id'] != '3') { ?>
                            <tr>
                                <th scope="col">View Details </th>
                                <td scope="col"><a href="<?php $notiurl = isset($notification[0]) && $notification[0]['page_id'] == '1' ?'clients':'edit-client/'.$notification[0]['client_id']; echo base_url($notiurl);?>" class="btn btn-success btn-sm" style="border-radius:0px;">Check Changes</a></td>
                            </tr>
                            <?php } ?>
                            <?php if ($session->userData['user_type'] == '1') { ?>
                            <tr>
                                <th scope="col">Delete Notification</th>
                                <td scope="col"><a style="border-radius:0;" href="javascript:;" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="return setNotificationId('<?php echo isset($notification[0]) ? $notification[0]['track_id']:''?>');">Delete</a></td>
                            </tr>
                            <?php } ?>
                        </thead>
                        
                    </table>
                    
                </div>
            </div>
        </div>
    </section>
</main>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <input type="hidden" name="notiId" id="notiId" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" onClick="return deleteNotification();">Yes, Delete</button>
      </div>
      
    </div>
  </div>
</div>

<script>
const setNotificationId = (notiId) => {
    document.getElementById('notiId').value = notiId;
}
const deleteNotification = () => {
    const notiId = document.getElementById('notiId').value;
    window.location.href = '<?php echo base_url('delete-notification')?>/'+notiId;
}
</script>