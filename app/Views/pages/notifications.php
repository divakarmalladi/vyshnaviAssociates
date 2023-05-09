<?php $session = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Notifications</h2>
          <ol>
            <li><a href="<?php echo base_url();?>/dashboard">Dashboard</a></li>
            <li>Notifications</li>
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
                                <th scope="col">#</th>
                                <th scope="col">Notification</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($notifications)) { 
                                foreach($notifications as $key => $value) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo (($pageNum - 1) * $limit) + ($key + 1) ;?></th>
                                <td width="55%"><?php echo $value['activity_description'];?></td>
                                <td><?php echo $value['user_name'];?></td>
                                <td><?php echo date('d-m-Y, h:i a', strtotime($value['created_date']));?></td>
                                <td>
                                  <a style="border-radius:0;" href="<?php echo base_url('view-notification/'.$value['track_id']);?>" class="btn <?php echo $value['view_status'] == 0?' btn-warning':' btn-success'?>  btn-sm">View</a>
                                  <?php if ($session->userData['user_type'] == '1') { ?>
                                  <a style="border-radius:0;margin-left:5px;" href="javascript:;" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="return setNotificationId('<?php echo $value['track_id']?>');">Delete</a>
                                  <?php } ?>
                                </td>
                            </tr>
                            <?php } } else {  ?>
                            <tr>
                              <td colspan="8"><h1 class="text-center">No Notifications Found</h1></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (isset($totalPages) && $totalPages > 1) { ?>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                        <li class="page-item <?php echo $pageNum==$firstPage? 'disabled':''?>">
                          <a class="page-link" href="<?php echo base_url('notifications/'.$firstPage);?>" tabindex="-1">First</a>
                        </li>
                        <li class="page-item <?php echo $pageNum==$firstPage? 'disabled':''?>">
                          <a class="page-link" href="<?php echo base_url('notifications/'.($pageNum-1));?>" tabindex="-1"><</a>
                        </li>
                        <?php if($totalPages < 20 ) { for($i = 1; $i<= $totalPages; $i++) {?>
                        <li class="page-item"><a class="page-link <?php echo $pageNum == $i? 'active':''?>" href="<?php echo base_url('notifications/'.$i);?>"><?php echo $i;?></a></li>
                        <?php } } else { for($i=$pageNum - 5; $i<$pageNum; $i++) { if ($i > $firstPage) { ?>
                          <li class="page-item"><a class="page-link <?php echo $pageNum == $i? 'active':''?>" href="<?php echo base_url('notifications/'.$i);?>"><?php echo $i;?></a></li>
                        <?php } } ?>
                        <?php for($j=$pageNum; $j<= ($pageNum+5); $j++) { if($j < $totalPages) { ?>
                          <li class="page-item"><a class="page-link <?php echo $pageNum == $j? 'active':''?>" href="<?php echo base_url('notifications/'.$j);?>"><?php echo $j;?></a></li>
                        <?php }} ?>
                        <?php } ?>
                        <li class="page-item <?php echo $pageNum == $lastPage ? 'disabled':''; ?>">
                          <a class="page-link" href="<?php echo base_url('notifications/'.($pageNum + 1));?>">></a>
                        </li>
                        <li class="page-item <?php echo $pageNum == $lastPage ? 'disabled':''; ?>">
                          <a class="page-link" href="<?php echo base_url('notifications/'.$lastPage);?>">Last</a>
                        </li>
                        
                      </ul>
                    </nav>
                    <?php } ?>
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