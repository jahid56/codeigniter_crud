<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage User</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h2><?php echo $pageTitle; ?></h2> 
            <a href="<?php echo base_url('user/create'); ?>" class="btn btn-info pull-right" style="margin-bottom: 10px"> <i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
            <?php if (!empty($all_data)) { ?>
                <table class="table table-bordered">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                        <col width="25%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>SL#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_data as $key => $aData) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $aData->name; ?></td>
                                <td><?php echo $aData->email; ?></td>
                                <td><?php echo $aData->phone; ?></td>
                                <td><img src="<?php echo $aData->image ? base_url('assets/image/thumbs/' . $aData->image) : base_url('assets/image/nophoto.jpg'); ?>" class="img-responsive img-thumbnail" alt="Profile Photo"></td>
                                <td>
                                    <a href="<?php echo site_url('user/view/' . $aData->user_id); ?>" class="btn btn-info" data-toggle="modal" data-target="#userModal">View</a> 
                                    <a href="<?php echo site_url('user/edit/' . $aData->user_id); ?>" class="btn btn-primary">Edit</a> 
                                    <a href="<?php echo site_url('user/delete/' . $aData->user_id); ?>" class="btn btn-danger" onclick = 'return confirm("Are you sure you want to delete it!");'>Delete</a> 
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <!-- Modal -->
        <div id="userModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>
        
        <script>
            /******bootstrap section ***/
            $(function () {
                // modal refrest in every load
                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                });
            });
        </script>
    </body>
</html>
