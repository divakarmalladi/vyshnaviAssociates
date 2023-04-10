
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>SMS</h2>
          <ol>
            <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
            <li>SMS</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12" style="text-align:right;">
                    <a href="<?php echo base_url();?>/send-sms" type="button" class="btn btn-outline-primary">Send SMS</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">SMS</th>
                                <th scope="col">Sent By</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sms)) { 
                                foreach($sms as $key => $value) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo (($pageNum - 1) * $limit) + ($key + 1) ;?></th>
                                <td><?php echo $value['client_name'];?></td>
                                <td><?php echo $value['client_phone'];?></td>
                                <td><?php echo $value['sms'];?></td>
                                <td><?php echo $value['user_name'];?></td>
                                <td><?php echo date('d-m-Y, h:i a', strtotime($value['sms_date']));?></td>
                            </tr>
                            <?php } } else {  ?>
                            <tr>
                              <td colspan="8"><h1 class="text-center">No SMS Found</h1></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (isset($totalPages) && $totalPages > 1) { ?>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                        <li class="page-item <?php echo $pageNum==$firstPage? 'disabled':''?>">
                          <a class="page-link" href="<?php echo base_url('sms-details/'.$firstPage);?>" tabindex="-1">First</a>
                        </li>
                        <li class="page-item <?php echo $pageNum==$firstPage? 'disabled':''?>">
                          <a class="page-link" href="<?php echo base_url('sms-details/'.($pageNum-1));?>" tabindex="-1"><</a>
                        </li>
                        <?php if($totalPages < 20 ) { for($i = 1; $i<= $totalPages; $i++) {?>
                        <li class="page-item"><a class="page-link <?php echo $pageNum == $i? 'active':''?>" href="<?php echo base_url('sms-details/'.$i);?>"><?php echo $i;?></a></li>
                        <?php } } else { for($i=$pageNum - 5; $i<$pageNum; $i++) { if ($i > $firstPage) { ?>
                          <li class="page-item"><a class="page-link <?php echo $pageNum == $i? 'active':''?>" href="<?php echo base_url('sms-details/'.$i);?>"><?php echo $i;?></a></li>
                        <?php } } ?>
                        <?php for($j=$pageNum; $j<= ($pageNum+5); $j++) { if($j < $totalPages) { ?>
                          <li class="page-item"><a class="page-link <?php echo $pageNum == $j? 'active':''?>" href="<?php echo base_url('sms-details/'.$j);?>"><?php echo $j;?></a></li>
                        <?php }} ?>
                        <?php } ?>
                        <li class="page-item <?php echo $pageNum == $lastPage ? 'disabled':''; ?>">
                          <a class="page-link" href="<?php echo base_url('sms-details/'.($pageNum + 1));?>">></a>
                        </li>
                        <li class="page-item <?php echo $pageNum == $lastPage ? 'disabled':''; ?>">
                          <a class="page-link" href="<?php echo base_url('sms-details/'.$lastPage);?>">Last</a>
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
        <input type="hidden" name="loginId" id="loginId" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" onClick="return deleteUser();">Yes, Delete</button>
      </div>
      
    </div>
  </div>
</div>

<script>
const setLoginId = (loginId) => {
    document.getElementById('loginId').value = loginId;
}
const deleteUser = () => {
    const loginId = document.getElementById('loginId').value;
    window.location.href = '<?php echo base_url('delete-user')?>/'+loginId;
}
</script>