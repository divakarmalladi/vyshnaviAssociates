
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Users</h2>
          <ol>
            <li><a href="<?php echo base_url();?>/user-dashboard">Dashboard</a></li>
            <li>Users</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page contact">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12" style="text-align:right;">
                    <a href="<?php echo base_url();?>/add-user" type="button" class="btn btn-outline-primary">Add User</a>
                </div>
                <div class="col-xl-12 col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Login ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">User</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)) { 
                                foreach($users as $key => $value) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1;?></th>
                                <td><?php echo $value['user_name'];?></td>
                                <td><?php echo $value['login_id'];?></td>
                                <td><?php echo $value['user_email'];?></td>
                                <td><?php echo $value['phone_number'];?></td>
                                <td><?php echo USER_TYPE_LIST[$value['user_type']];?></td>
                                <td><a style="border-radius:0px;" href="<?php echo base_url('edit-user/'.$value['login_id']);?>" class="btn btn-primary btn-sm"> Edit </a> <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="return setLoginId('<?php echo $value['login_id']?>');"> Delete </button></td>
                            </tr>
                            <?php } } else {  ?>
                            <tr>
                              <td colspan="8"><h1 class="text-center">No Users Found</h1></td>
                            </tr>
                            <?php } ?>
                        </tbody>
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