<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
        <!-- Website CSS style -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>">

        <title>Edit User</title>
    </head>
    <body>
        <div class="container">
            <div class="row main">
                <div class="panel-heading">
                    <div class="panel-title text-center">
                        <h1 class="title">User Form</h1>

                    </div>
                </div> 
                <div class="main-login main-center">
                    <?php if (validation_errors()) { ?>
                        <div role="alert" class="alert alert-warning">
                            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                            <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('success_msg')) { ?>
                        <div class="alert alert-success fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <?php echo $this->session->flashdata('success_msg'); ?>
                        </div>
                    <?php } ?>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">User Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $getData->name); ?>" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" name="email" value="<?php echo set_value('email', $getData->email); ?>" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone', $getData->phone); ?>" placeholder="Enter Phone">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" value="" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="re_password">Confirm Password</label>
                            <input type="password" class="form-control" name="re_password" value="" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <?php $image = $getData->image? base_url('assets/image/thumbs/'.$getData->image) : '#' ?>
                            <label for="exampleInputFile">Image Upload</label>
                            <div class="clearfix"></div>
                            <img id="blah" src="<?php echo $image?>" alt="your image" class="img-responsive img-thumbnail" style="margin-bottom: 10px; height: 130px;" />
                            <input type='file' id="imgInp" class="form-control-file" name="image" />
                            
                        </div>

                        <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
        <script>
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function () {
                readURL(this);
            });
        </script>
    </body>
</html>