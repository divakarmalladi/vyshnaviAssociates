<?php $sess = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Clients</h2>
          <ol>
            <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
            <li>Clients</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <div class="row">
                <!-- <div class="col-xl-12 col-md-12" style="text-align:right;">
                    <a href="<?php echo base_url();?>/clients" type="button" class="btn btn-outline-primary">Add User</a>
                </div> -->
                <div class="col-xl-12 col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Client ID</th>
                                <!-- <th scope="col">Aadhar</th> -->
                                <th scope="col">Phone</th>
                                <th scope="col">Project</th>
                                <?php if ($sess->userData['user_type'] != 3) { ?>
                                <th scope="col">Alloted To</th>
                                <th scope="col">Registered By</th>
                                <?php } ?>
                                
                                <th scope="col">Registered Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($clients)) { 
                                foreach($clients as $key => $value) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo (($pageNum - 1) * $limit) + ($key + 1) ;?></th>
                                <td><?php echo $value['customer_name'];?></td>
                                <td><?php echo $value['customer_id'];?></td>
                                <!-- <td><?php //echo $value['aadhar_number'];?></td> -->
                                <td><?php echo $value['contact_number'];?></td>
                                <td><?php echo $value['type_of_project'];?></td>
                                <?php if ($sess->userData['user_type'] != 3) { ?>
                                <td><?php echo $value['user_name'];?></td>
                                <td><?php echo $value['luser_name'];?></td>
                                <?php } ?>
                                
                                <td><?php echo date('d-m-y h:ia', strtotime($value['created_date']));?></td>
                                <td><a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModalstatus" onClick="return setFileId('<?php echo $value['customer_id']?>', '<?php echo !empty($value['file_status_code']) ? $value['file_status_code']:'';?>');"><?php echo !empty($value['file_status_code']) ? $value['file_status_code']:'Update';?></a>
                                <p id="file_text_<?php echo $value['customer_id']; ?>_para" style="display:none;"><?php echo !empty($value['file_text']) ? $value['file_text']:'';?></p>
                                </td>
                                <td>
                                  <?php if ($sess->userData['user_type'] == 1) { ?>
                                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalemp" onClick="return setUserId('<?php echo $value['customer_id']?>', '<?php echo $value['alloted_id'];?>');"> Allot </button>
                                  <?php } ?>
                                  <a style="border-radius:0px;" href="<?php echo base_url('edit-client/'.$value['customer_id']);?>" class="btn btn-primary btn-sm"> Edit </a> 
                                  <?php if ($sess->userData['user_type'] != 3) { ?>
                                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="return setCustomerId('<?php echo $value['customer_id']?>');"> Delete </button>
                                  <?php } ?>
                                </td>
                            </tr>
                            <?php } } else {  ?>
                            <tr>
                              <td colspan="8"><h1 class="text-center">No Clients Found</h1></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (isset($totalPages) && $totalPages > 1) { ?>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                        <li class="page-item <?php echo $pageNum==$firstPage? 'disabled':''?>">
                          <a class="page-link" href="<?php echo base_url('clients/'.$firstPage);?>" tabindex="-1">First</a>
                        </li>
                        <li class="page-item <?php echo $pageNum==$firstPage? 'disabled':''?>">
                          <a class="page-link" href="<?php echo base_url('clients/'.($pageNum-1));?>" tabindex="-1"><</a>
                        </li>
                        <?php if($totalPages < 20 ) { for($i = 1; $i<= $totalPages; $i++) {?>
                        <li class="page-item"><a class="page-link <?php echo $pageNum == $i? 'active':''?>" href="<?php echo base_url('clients/'.$i);?>"><?php echo $i;?></a></li>
                        <?php } } else { for($i=$pageNum - 5; $i<$pageNum; $i++) { if ($i > $firstPage) { ?>
                          <li class="page-item"><a class="page-link <?php echo $pageNum == $i? 'active':''?>" href="<?php echo base_url('clients/'.$i);?>"><?php echo $i;?></a></li>
                        <?php } } ?>
                        <?php for($j=$pageNum; $j<= ($pageNum+5); $j++) { if($j < $totalPages) { ?>
                          <li class="page-item"><a class="page-link <?php echo $pageNum == $j? 'active':''?>" href="<?php echo base_url('clients/'.$j);?>"><?php echo $j;?></a></li>
                        <?php }} ?>
                        <?php } ?>
                        <li class="page-item <?php echo $pageNum == $lastPage ? 'disabled':''; ?>">
                          <a class="page-link" href="<?php echo base_url('clients/'.($pageNum + 1));?>">></a>
                        </li>
                        <li class="page-item <?php echo $pageNum == $lastPage ? 'disabled':''; ?>">
                          <a class="page-link" href="<?php echo base_url('clients/'.$lastPage);?>">Last</a>
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
<div class="modal fade" id="exampleModalstatus" tabindex="-1" aria-labelledby="exampleModalstatusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalstatusLabel">File Status</h5>
        <input type="hidden" name="filecustomerId" id="filecustomerId" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 php-email-form clientReg"  method="post">
          <div class="col-md-6 mb-3">
              <label for="file_status" class="form-label">File Status</label>
              <select id="file_status" name="file_status" class="form-select" onChange="return showComments(this.value)">
                  <option value="">Choose...</option>
                  <option value="Finished">Finished</option>
                  <option value="Pending">Pending</option>
                  <option value="Shortfall">Shortfall</option>
              </select>
              <ul id="file_status_text_notes" style="list-style-type: disclosure-closed;"></ul>
              <div id="file_status_text" style="display:none;">
                <textarea class="form-control" id="file_status_notes"  name="file_status_notes" aria-label="With textarea"></textarea>
                <span id="file_status_error"></span>
              </div>
          </div>
          <div class="my-2">
              <div class="loading" id="file-loading" style="display:none;">Loading</div>
              <div class="error-message" id="file-error-message"></div>
              <div class="sent-message" id="file-success-message"></div>
          </div>
        </form>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Go Back</button>
        <button type="button" class="btn btn-success" onClick="return saveFileStatus();">Save</button>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalemp" tabindex="-1" aria-labelledby="exampleModalempLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalempLabel">Allot the client to Employee</h5>
        <input type="hidden" name="login_Id" id="login_Id" value="">
        <input type="hidden" name="customerId" id="customerId" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 php-email-form clientReg"  method="post">
          <div class="col-md-6 mb-3">
              <label for="employee_id" class="form-label">Select Employee</label>
              <select id="employee_id" name="employee_id" class="form-select" onChange="return updateEmployeeId(this.value)">
                  <option value="">Choose...</option>
                  <?php if (isset($users)) { 
                    foreach($users as $userKey => $userVal) {
                  ?>
                  <option value="<?php echo $userVal['login_id'];?>" ><?php echo  $userVal['user_name'].' - '.$userVal['login_id'];?></option>
                  <?php } } ?>
              </select>
          </div>
          <div class="my-2">
              <div class="loading" id="loading" style="display:none;">Loading</div>
              <div class="error-message" id="error-message"></div>
              <div class="sent-message" id="success-message"></div>
          </div>
        </form>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Go Back</button>
        <button type="button" class="btn btn-success" onClick="return allotClient();">Allot</button>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <input type="hidden" name="customer_id" id="customer_id" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" onClick="return deleteClient();">Yes, Delete</button>
      </div>
      
    </div>
  </div>
</div>

<script>
const setFileId = (customer_id, fileStatus) => {
    document.getElementById('filecustomerId').value = customer_id;
    const paraText = $('#file_text_'+customer_id+'_para').text();
    const frameText = paraText ? paraText.split('###'):[];
    console.log(frameText);
    let textPara = '';
    if (frameText.length > 0) {
      for (var i = 0; i < frameText.length ; i++) {
        if (frameText[i] != '') {
          textPara = textPara + '<li>'+frameText[i]+'</li>';
        }
      }
    }
    $('#file_status_text_notes').html(textPara);
    $('#file_status').val(fileStatus);
    if (fileStatus!='' && fileStatus !='Finished') {
      $('#file_status_text').show();
      $('#file_status_text_notes').show();
    } else {
      $('#file_status_text').hide();
      $('#file_status_text_notes').hide();
    }
}
function showComments(val){
  console.log(val);
  if (val !='Finished') {
    $('#file_status_text').show();
    $('#file_status_text_notes').show();
  } else {
    $('#file_status_text').hide();
    $('#file_status_text_notes').hide();
  }
}
const saveFileStatus = () => {
  $('#file-success-message').html();
  $('#file-error-message').html();
  const customerId = $('#filecustomerId').val();
  const notesText = $('#file_status_notes').val();
  const fileStatus = $('#file_status').val();
  const paraText = $('#file_text_'+customerId+'_para').text();
  $('#file-loading').show();
  if (customerId != '') {
    const formData = {'customerId': customerId, 'notesText': notesText, 'fileStatus': fileStatus, 'paraText':paraText}
    $.ajax({
      url:"<?php echo base_url();?>/update-file-status",
      method:"POST",
      data: JSON.stringify(formData),
      dataType: "json",
      contentType: "application/json; charset=utf-8",
    }).done(function( response ) {
      console.log(response);
      if (response.status == 200) {
        $('#file-success-message').html('File Status Updated Successfully').css('color', 'green');
        $('#filecustomerId').val('');
        setTimeout(() => {
          window.location.href = '<?php echo base_url();?>/clients';
        }, 300);
      } 
      $('#file-loading').hide();
    }).fail(function( jqXHR, textStatus ) {
      $('#file-error-message').html('Something went wrong, Please try again').css('color', 'red');
      $('#file-loading').hide();
    });
  } else {
    $('#file-loading').hide();
    $('#file-error-message').html('Please select the employee').css('color', 'red');
  }
}
const setCustomerId = (customer_id) => {
    document.getElementById('customer_id').value = customer_id;
}
const setUserId = (customer_id, user_id) => {
  $('#employee_id').val(user_id);
  document.getElementById('customerId').value = customer_id;
  document.getElementById('login_Id').value = user_id;
}
const updateEmployeeId = (val) => {
  document.getElementById('login_Id').value = val;
}
const deleteClient = () => {
    const customer_id = document.getElementById('customer_id').value;
    window.location.href = '<?php echo base_url('delete-client')?>/'+customer_id;
}
const allotClient = () => {
  const loginId = $('#login_Id').val();
  const customerId = $('#customerId').val();
  $('#loading').show();
  if (loginId != '') {
    const formData = {'loginId': loginId, 'customerId': customerId}
    $.ajax({
      url:"<?php echo base_url();?>/allot-client",
      method:"POST",
      data: JSON.stringify(formData),
      dataType: "json",
      contentType: "application/json; charset=utf-8",
    }).done(function( response ) {
      console.log(response);
      if (response.status == 200) {
        $('#success-message').html('Client allotted Successfully').css('color', 'green');
        $('#employee_id').val('');
        setTimeout(() => {
          window.location.href = '<?php echo base_url();?>/clients';
        }, 300);
      } 
      $('#loading').hide();
    }).fail(function( jqXHR, textStatus ) {
      $('#error-message').html('Something went wrong, Please try again').css('color', 'red');
      $('#loading').hide();
    });
  } else {
    $('#loading').hide();
    $('#error-message').html('Please select the employee').css('color', 'red');
  }
}

</script>