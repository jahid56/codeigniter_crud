<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Modal Header</h4>
</div>

<div class="modal-body" style="overflow: hidden">
    <div class="col-md-9">
        <table class="table table-bordered">

            <tbody>
                <tr>
                    <td width="30%">User Name</td>
                    <td><?php echo $getData->name; ?></td>
                </tr>
                <tr>
                    <td>Email Address</td>
                    <td><?php echo $getData->email; ?></td>
                </tr>

                <tr>
                    <td>Phone</td>
                    <td><?php echo $getData->phone; ?></td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <img src="<?php echo base_url('assets/image/' . $getData->image); ?>" class="img-responsive img-thumbnail" title="" alt="">
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>