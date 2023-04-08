<?php $sessClient = session();?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Client Registration</h2>
          <ol>
            <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
            <li>Client Registration</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <form class="row g-3 php-email-form clientReg" id="clientRegistration" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label">Client Name</label>
                    <input type="text" name="customer_name" class="form-control" id="customer_name" value="<?php echo isset($clientData) ? $clientData->customer_name:'';?>">
                </div>
                <div class="col-md-6">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" id="contact_number" value="<?php echo isset($clientData) ? $clientData->contact_number:'';?>">
                </div>
                <div class="col-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St" value="<?php echo isset($clientData) ? $clientData->address:'';?>">
                </div>
                <div class="col-6">
                    <label for="reference" class="form-label">Reference</label>
                    <input type="text" name="reference" class="form-control" id="reference" value="<?php echo isset($clientData) ? $clientData->reference:'';?>">
                </div>
                <div class="col-md-4">
                    <label for="aadhar_number" class="form-label">Aadhar Number</label>
                    <input type="text" name="aadhar_number" class="form-control" id="aadhar_number" value="<?php echo isset($clientData) ? $clientData->aadhar_number:'';?>">
                </div>
                <div class="col-md-4">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="<?php echo isset($clientData) ? $clientData->date_of_birth:'';?>">
                </div>
                <div class="col-md-4">
                    <label for="type_of_project" class="form-label">Type of Project</label>
                    <select id="type_of_project" name="type_of_project" class="form-select">
                        <option value="">Choose...</option>
                        <option value="Municipality" <?php echo isset($clientData) &&$clientData->type_of_project === 'Municipality' ? 'selected':'';?>>Municipality</option>
                        <option value="Panchayat" <?php echo isset($clientData) &&$clientData->type_of_project === 'Panchayat' ? 'selected':'';?>>Panchayat</option>
                    </select>
                </div>
                <?php 
                if (isset($clientData) && $clientData->customer_id) {
                  foreach(CHECK_LIST as $key => $value) { 
                ?>
                <div class="col-12">
                    <div class="switchLayout form-check">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="<?php echo $key?>" type="checkbox" id="<?php echo $key?>" onChange="return showSublist('<?php echo $key;?>');" <?php echo isset($docData) && isset($docData[$key]) ? 'checked':'';?>>
                            <label class="form-check-label" for="<?php echo $key?>"><?php echo $value;?></label>
                        </div>
                    </div>

                    <div class="sublist" style="<?php echo isset($docData) && isset($docData[$key]) ? 'display:block':'display:none';?>" id="<?php echo $key?>">
                        <?php if (isset(CHECK_LIST_SUB_ITEMS[$key])) { foreach(CHECK_LIST_SUB_ITEMS[$key] as $subkey => $subvalue) { 
                          $checkedStatus = false;
                          $docInfo = [];
                          if (isset($docData[$key][$subkey])) {
                            $checkedStatus = true;
                            // if($subvalue == 'Others') {
                            //   $docInfo = $docData[$key][$subkey];
                            // }else {
                            //   $docInfo = $docData[$key][$subkey][0];
                            // }
                            $docInfo = $docData[$key][$subkey];
                            //echo '<pre>';print_r($docInfo);echo '</pre>';
                          }
                        ?>
                            <div class="form-check">
                                <div class="form-check">
                                                                
                                    <input class="form-check-input" name="<?php echo $subkey?>" type="checkbox" id="<?php echo $subkey?>" onChange="return showButtons('<?php echo $key.$subkey;?>');" <?php echo $checkedStatus ? 'checked': '';?>>
                                    <label class="form-check-label btnSection" for="<?php echo $subkey;?>">
                                    <?php echo $subvalue;?>  <span style="display:none;" title="<?php echo isset($docInfo['actual_file_name']) ? $docInfo['actual_file_name'] : '';?>"><?php echo isset($docInfo['actual_file_name']) ? substr($docInfo['actual_file_name'], 0, 20) : '';?></span>
                                    <div class="btnSection" id="<?php echo $key.$subkey;?>" style="<?php echo $checkedStatus ? '': 'display:none;';?>">
                                        <div class="formInput">
                                        
                                        <?php /*if($subvalue == 'Others') {*/ ?>
                                          <?php if($sessClient->userData && $sessClient->userData['user_type'] != 3 || $subvalue == 'Autocad Attachment') {?>
                                          <input class="form-control form-control-sm verifyDocsUpload" id="formFileSm<?php echo $key.$subkey;?>" data-doc="" type="file" value="" name="verifyDocs[<?php echo $key ?>][<?php echo $subkey?>][]" multiple>
                                          <?php } ?>
                                          <?php /*} else { ?>
                                            <?php if($sessClient->userData && $sessClient->userData['user_type'] != 3 || $subvalue == 'Autocad Attachment') { ?>
                                            <input class="form-control form-control-sm verifyDocsUpload" id="formFileSm<?php echo $key.$subkey;?>" type="file" value="" name="verifyDocs[<?php echo $key ?>][<?php echo $subkey?>]">
                                            <?php } ?>
                                          <?php }*/?>
                                          
                                        </div>
                                        <!-- <button type="button" class="btn btn-primary">Save</button> -->
                                        <?php /*if($subvalue != 'Others') { ?> 
                                        <div class="buttonsa" id="buttonsa<?php echo $key.$subkey;?>" style="<?php echo isset($docInfo['checklist']) ? '': 'display:none;'; ?>">
                                          
                                          <a href="javascript:;" title="<?php echo isset($docInfo['actual_file_name']) ? $docInfo['actual_file_name'] : '';?>" onClick="return viewFile(this)" data-doc="<?php echo isset($docInfo['doc_id']) ? $docInfo['doc_id']: '';?>" data-id="<?php echo 'documents/'.(isset($docInfo['customer_id'])?$docInfo['customer_id']:'').'/'.$key.'/'.(isset($docInfo['file_name'])?$docInfo['file_name']:'');?>" onClick="return downloadFile(this)"  id="download<?php echo $key.$subkey;?>" type="button" class="btn btn-success">View</a>
                                          <?php if($sessClient->userData && $sessClient->userData['user_type'] != 3) { ?> 
                                          <a href="javascript:;" 
                                          title="<?php echo isset($docInfo['actual_file_name']) ? $docInfo['actual_file_name'] : '';?>" 
                                          id="delete<?php echo $key.$subkey;?>" 
                                          type="button" class="btn btn-danger" 
                                          data-doc="<?php echo isset($docInfo['doc_id']) ? $docInfo['doc_id']: '';?>" 
                                          data-customer="<?php echo (isset($docInfo['customer_id'])?$docInfo['customer_id']:'');?>" 
                                          data-id="<?php echo $key.$subkey;?>" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#exampleModalFileDelete" 
                                          onClick="return setCustomerId(this);">Delete</a>
                                          <?php } ?>
                                        </div>
                                        <?php }*/?>
                                    </div>
                                    </label>
                                </div>
                            </div>
                            <?php /*if($subvalue == 'Others') {  */
                                          foreach ($docInfo as $docKey => $docVal) {
                                        ?>
                                        <div class="row" style="margin-left: 30px; margin-bottom:5px;">
                                        
                                        <a href="javascript:;" class="col-md-4" style="display:inline-block;" title="<?php echo isset($docVal['actual_file_name']) ? $docVal['actual_file_name'] : '';?>"><?php echo substr($docVal['actual_file_name'], 0, 30)?></a>
                                        <?php if($sessClient->userData && $sessClient->userData['user_type'] != 3 || $subvalue == 'Autocad Attachment') { ?>
                                          <div class="col-md-4">
                                          <input style="width:auto;height:auto;" class="form-control form-control-sm verifyDocsUpload" id="formFileSm<?php echo $key.$subkey.'-'.$docKey;?>" data-doc="<?php echo isset($docVal['doc_id']) ? $docVal['doc_id']: '';?>" type="file" value="" name="verifyDoc[<?php echo $key ?>][<?php echo $subkey?>][]">
                                          </div>
                                          <?php } ?>
                                        <div class="buttonsa col-md-4" id="buttonsa<?php echo $key.$subkey.(isset($docVal['doc_id']) ? $docVal['doc_id']: '');?>" style="<?php echo isset($docVal['checklist']) ? '': 'display:none;'; ?>">
                                          
                                          <a href="javascript:;" title="<?php echo isset($docVal['actual_file_name']) ? $docVal['actual_file_name'] : '';?>" onClick="return viewFile(this)" data-doc="<?php echo isset($docVal['doc_id']) ? $docVal['doc_id']: '';?>" data-id="<?php echo 'documents/'.(isset($docVal['customer_id'])?$docVal['customer_id']:'').'/'.$key.'/'.(isset($docVal['file_name'])?$docVal['file_name']:'');?>" onClick="return downloadFile(this)"  id="download<?php echo $key.$subkey.(isset($docVal['doc_id']) ? $docVal['doc_id']: '');?>" type="button" class="btn btn-success">View</a>
                                          <?php if($sessClient->userData && $sessClient->userData['user_type'] != 3) { ?>
                                          <a href="javascript:;" 
                                          title="<?php echo isset($docVal['actual_file_name']) ? $docVal['actual_file_name'] : '';?>" 
                                          id="delete<?php echo $key.$subkey.(isset($docVal['doc_id']) ? $docVal['doc_id']: '');?>" 
                                          type="button" class="btn btn-danger" 
                                          data-doc="<?php echo isset($docVal['doc_id']) ? $docVal['doc_id']: '';?>" 
                                          data-customer="<?php echo (isset($docVal['customer_id'])?$docVal['customer_id']:'');?>" 
                                          data-id="<?php echo $key.$subkey.(isset($docVal['doc_id']) ? $docVal['doc_id']: '');?>" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#exampleModalFileDelete" 
                                          onClick="return setCustomerId(this);">Delete</a>
                                          <?php } ?>
                                        </div>
                                        </div>
                                        <?php } /*}*/ ?> 
                        <?php  } } ?>
                        <div class="col-12 mt-3" style="display:none;">
                          <fieldset class="statusFieldset">
                            <legend>Status of <?php echo  ucwords(str_replace('_', ' ', $key));?></legend>
                          </fieldset>
                        </div>
                        <div class="col-6">
                            <label for="notes_<?php echo $key;?>" class="form-label">Notes</label>
                            <div class="col-12" id="notes_<?php echo $key;?>_section" style="border:1px solid #ccc; padding: 10px; margin: 0px;">
                              <?php if (isset($noteData[$key])) {
                                foreach($noteData[$key] as $notekey => $noteval) {
                              ?>
                              <div id="notes_<?php echo $key.$noteval['note_id'];?>">
                                <div id="notes_<?php echo $key.$noteval['note_id'];?>_item" style="display:block;">
                                  <span><?php echo $noteval['user_id']?></span> : <span id="text_notes_<?php echo $key.$noteval['note_id'];?>"><?php echo $noteval['notes']?></span>
                                  <?php /*
                                  <div id="notes_<?php echo $key.$noteval['note_id'];?>_buttons" style="display:inline-block;">

                                    <a href="javascript:;" id="edit_notes_<?php echo $noteval['note_id'];?>"  data-id="<?php echo $key.$noteval['note_id'];?>" data-note="<?php echo $noteval['note_id'];?>" class="btn btn-primary notesbutton edit_note" onClick="return edit_cancel_notes(this)">Edit</a>

                                    <a href="javascript:;" id="edit_notes_<?php echo $noteval['note_id'];?>"  data-id="<?php echo $key.$noteval['note_id'];?>" data-note="<?php echo $noteval['note_id'];?>" class="btn btn-danger notesbutton edit_note"  data-bs-toggle="modal" 
                                          data-bs-target="#exampleModalNoteDelete" 
                                          onClick="return setNoteId(this);">Delete</a>
                                  </div> 
                                  */ ?>
                                </div>
                                <?php /*
                                <div style="display:none;" id="notes_<?php echo $key.$noteval['note_id'];?>_edit">
                                  <input type="text" value="<?php echo $noteval['notes']?>" id="notes_<?php echo $key.$noteval['note_id'];?>_text" class="form-control" />
                                  <span id="<?php echo $key.$noteval['note_id'];?>_error"></span>
                                  <a href="javascript:;" id="save_notes_<?php echo $noteval['note_id'];?>"  data-id="<?php echo $key.$noteval['note_id'];?>" data-note="<?php echo $noteval['note_id'];?>"  onClick="return save_notes(this)" class="btn btn-success notesbutton">Save</a>
                                  
                                  <a href="javascript:;" id="edit_notes_<?php echo $noteval['note_id'];?>"  data-id="<?php echo $key.$noteval['note_id'];?>" data-note="<?php echo $noteval['note_id'];?>" class="btn btn-warning notesbutton edit_note" onClick="return edit_cancel_notes(this)">Cancel</a>
                                </div>  
                                */ ?>
                                
                              </div>
                              <?php } } ?>
                            </div>
                            <textarea class="form-control" id="notes_<?php echo $key;?>"  name="notes[<?php echo $key;?>]" aria-label="With textarea"></textarea>
                            <span id="notes_<?php echo $key;?>_error"></span>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="loading" id="loadingmote">Loading</div>
                            <button type="button" class="btn btn-primary" onClick="return saveNotes('<?php echo $key;?>','notes_<?php echo $key;?>')">Save</button>
                        </div>
                    </div>
                </div>
                
                <?php } }?>
                <div class="my-2">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo isset($clientData) ? $clientData->customer_id:'';?>">
                    <input type="hidden" id="file_name" name="file_name" value="">
                    <input type="hidden" id="doc_id_update" name="doc_id_update" value="">
                    <input type="hidden" id="file_sub_name" name="file_sub_name" value="">
                    <div class="loading" id="loading">Loading</div>
                    <div class="error-message" id="error-message"></div>
                    <div class="sent-message" id="success-message"></div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>
</main>
<div class="modal fade" id="exampleModalFileDelete" tabindex="-1" aria-labelledby="exampleModalFileDeleteLabel" aria-hidden="true">
  <div class="modal-dialog contact">
    <div class="modal-content php-email-form">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalFileDeleteLabel">Are you sure?</h5>
        <input type="hidden" name="del_customer_id" id="del_customer_id" value="">
        <input type="hidden" name="del_doc_id" id="del_doc_id" value="">
        <input type="hidden" name="delete_id" id="delete_id" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="sent-message" id="del-success-message"></div>
        <div class="loading" id="loadingModal" style="display:none;">Loading</div>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" onClick="return deleteFile();">Yes, Delete</button>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalNoteDelete" tabindex="-1" aria-labelledby="exampleModalNoteDeleteLabel" aria-hidden="true">
  <div class="modal-dialog contact">
    <div class="modal-content php-email-form">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalNoteDeleteLabel">Are you sure?</h5>
        <input type="hidden" name="del_note_id" id="del_note_id" value="">
        <input type="hidden" name="del_note_ele_id" id="del_note_ele_id" value="">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="sent-message" id="note-success-message"></div>
        <div class="loading" id="loadingModalNote" style="display:none;">Loading</div>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" onClick="return deleteNote();">Yes, Delete</button>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript">
    const edit_cancel_notes = (e) => {
      const showId = $(e).attr('data-id');
      $('#'+showId+'_error').html('');
      $('#notes_'+showId+'_edit').toggle();
      $('#notes_'+showId+'_item').toggle();
    };
    function save_notes(e) {
      const noteelementId = $(e).attr('data-id');
      const noteId = $(e).attr('data-note');
      const elementId = $(e).attr('id');
      const notes = $('#notes_'+noteelementId+'_text').val();
      // console.log(noteelementId, noteId, elementId, notes);
      $('#loadingmote').show();
      if (notes.trim() == '') {
        $('#'+noteelementId+'_error').html('Please enter notes').css('color', 'red');
      } else {
        const formData = {'notes': notes, 'note_id': noteId, 'action':'update'}
        $.ajax({
          url:"<?php echo base_url();?>/save-notes",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          if (response.status == 200) {
            $('#text_notes_'+noteelementId).html(notes);
            const showId = $(e).attr('data-id');
            $('#notes_'+showId+'_edit').toggle();
            $('#notes_'+showId+'_item').toggle();
          } 
          $('#loadingmote').hide();
        }).fail(function( jqXHR, textStatus ) {
          $('#'+noteelementId+'_error').html('Something went wrong').css('color', 'red');
          $('#loadingmote').hide();
        });
        
      }
    }
    const setNoteId  = (e) => {
      $('#note-success-message').html('');
      const del_id = $(e).attr('data-note');
      const ele_id = $(e).attr('data-id');
      document.getElementById('del_note_id').value = del_id;
      document.getElementById('del_note_ele_id').value = ele_id;
    }
    function deleteNote(e) {
      const noteId = $('#del_note_id').val();
      const noteElementId = $('#del_note_ele_id').val();
      console.log(noteElementId);
      $('#loadingModalNote').show();
      if (noteId) {
        const formData = {'noteId': noteId}
        $.ajax({
          url:"<?php echo base_url();?>/delete-notes",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          $('#loadingModalNote').hide();
          $('#notes_'+noteElementId).remove();
          $('#exampleModalNoteDelete').modal('hide');
          
        }).fail(function( jqXHR, textStatus ) {
          $('#note-success-message').html('Something went wrong, Please try again').css('color', 'red').show();
          $('#loadingModalNote').hide();
        });
      }
    }
    function showSublist(checklist) {
        $('.sublist#'+checklist).toggle();
    }
    function showButtons(buttonSection) {
        $('#'+buttonSection).toggle();
    }
    function viewFile(e) {
      const fileId = $(e).attr('data-doc');
      window.location.href = '<?php echo base_url();?>/view-file/'+fileId;
    }
    function deleteFile(e) {
      const customerId = $('#del_customer_id').val();
      const fileId = $('#del_doc_id').val();
      $('#loadingModal').show();
      if (customerId && fileId) {
        const formData = {'fileId': fileId, 'customerId': customerId}
        $.ajax({
          url:"<?php echo base_url();?>/delete-file",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          if (response.status == 200) {
            $('#del-success-message').html('File Deleted Successfully').css('color', 'green').show();
            $('#del_customer_id').val('');
            $('#del_doc_id').val('');
            
            $('#buttonsa'+$('#delete_id').val()).parent().remove().css('display','none')
            $('#delete_id').val('');
            $('#exampleModalFileDelete').modal('hide');
          } 
          $('#loadingModal').hide();
        }).fail(function( jqXHR, textStatus ) {
          $('#del-success-message').html('Something went wrong, Please try again').css('color', 'red').show();
          $('#loadingModal').hide();
        });
      }
    }
    const setCustomerId  = (e) => {
      $('#del-success-message').html('');
      const customer_id = $(e).attr('data-customer');
      const file_id = $(e).attr('data-doc');
      const del_id = $(e).attr('data-id');
      document.getElementById('del_customer_id').value = customer_id;
      document.getElementById('del_doc_id').value = file_id;
      document.getElementById('delete_id').value = del_id;
      
    }
    function downloadFile(e) {
      const filePath = $(e).attr('data-id');
      console.log(e, filePath);
    }

    function saveNotes(checklist, notesId) {
      const notes = $('#'+notesId).val();
      $('#loadingmote').show();
      if (notes.trim() == '') {
        $('#'+notesId+'_error').html('Please enter notes').css('color', 'red');
      } else {
        const formData = {'notes': notes, 'checklist': checklist, 'customer_id' : $('#customer_id').val()}
        $.ajax({
          url:"<?php echo base_url();?>/save-notes",
          method:"POST",
          data: JSON.stringify(formData),
          dataType: "json",
          contentType: "application/json; charset=utf-8",
        }).done(function( response ) {
          console.log(response);
          if (response.status == 200) {
            const noteElementId = checklist+response.notesId;
            const noteHtml = '<div id="notes_'+noteElementId+'"><div id="notes_'+noteElementId+'_item" style="display:block;"><span>'+response.userId+'</span> : <span id="text_notes_'+noteElementId+'">'+notes+'</span></div></div>';
            $('#'+notesId+'_section').append('<p>'+noteHtml+'</p>');
            $('#'+notesId+'_error').html('Notes Saved Successfully').css('color', 'green');
            $('#'+notesId).val('');
          } 
          $('#loadingmote').hide();
        }).fail(function( jqXHR, textStatus ) {
          $('#'+notesId+'_error').html('Something went wrong').css('color', 'red');
          $('#loadingmote').hide();
        });
        
      }
    }

</script>
<script type="text/javascript">
  $(document).ready(() => {
    $('#clientRegistration').validate({
      rules: {
        customer_name: {
              required: true,
        },
        address: {
              required: true,
        },
        // reference: {
        //       required: true,
        // },
        aadhar_number: {
            required: true,
            digits: true,
        },
        // date_of_birth: {
        //     required: true,
        // },
        contact_number: {
            required: true,
            digits: true,
        },
        type_of_project: {
            required: true,
        },
      },
      submitHandler: function() { 
        const formData = {
          'customer_name': $('#customer_name').val(),
          'address' : $('#address').val(),
          'reference': $('#reference').val(),
          'aadhar_number' : $('#aadhar_number').val(),
          'date_of_birth': $('#date_of_birth').val(),
          'contact_number' : $('#contact_number').val(),
          'type_of_project' : $('#type_of_project').val(),
          'customer_id' : $('#customer_id').val(),
        }
        // const form = $('clientRegistration');
        // const formData = new FormData(form[0]);
        $('#loading').show();
        $('#success-message').hide();
        $('#error-message').hide();
        $.ajax({
          url:"<?php echo base_url();?>/client-registration",
          method:"POST",
          data: JSON.stringify(formData),
          // data: formData,
          dataType: "json",
          // contentType: false,
          // processData: false,
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
    $('.verifyDocsUpload').on('change', (e) => {
        console.log($('#'+e.target.id).attr('data-doc'), $(this), $(this)[0]);
        $('#file_name').val(e.target.id);
        $('#doc_id_update').val($('#'+e.target.id).attr('data-doc'));
        const formData = new FormData($('#clientRegistration')[0]);
        $.ajax({
          url:"<?php echo base_url();?>/client-registration/fileUpload",
          method:"POST",
          data: formData,
          async: false,
          cache: false,
          contentType: false,
          enctype: 'multipart/form-data',
          processData: false,
        }).done(function( res ) {
          const response = JSON.parse(res);
          if (response.status == 200) {
            $('#success-message').html(response.message).show();
            const filePath = 'documents/'+response.customerId+'/'+response.checklist+'/'+response.file_path;
            $('#download'+response.checklist+response.subchecklist).attr('data-id', filePath).attr('data-doc', response.doc_id);

            $('#delete'+response.checklist+response.subchecklist).attr('data-customer', response.customerId).attr('data-doc', response.doc_id).attr('data-id', response.checklist+response.subchecklist);

            $('#buttonsa'+response.checklist+response.subchecklist).show();
            location.reload();
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
    });
  })
  
</script>