<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Partner | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
    .error{ color:red; } 
    </style>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Partner</b><br>Login System</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign In</p>
        <?php $this->load->helper('form'); ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>                    
            </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>                    
            </div>
        <?php } ?>
        <div class="row">
          <div class="col-lg-6">
          <img src="<?php echo base_url();?>assets/images/insurance.png" alt="" srcset="" style="width: 300px;">
          </div>
          <div class="col-lg-6">
        <!-- <form action="<?php echo base_url(); ?>loginMe" method="post"> -->
        <form action="javascript:void(0)" method="post" id="formlogin">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="emailnumber" id="emailnumber" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">                         
            </div><!-- /.col -->
            <div class="col-xs-4">
              <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" />
            </div><!-- /.col -->
            <div class="col-xs-4">
            </div>
          </div>
        </form>
        <span><a href="<?php echo base_url() ?>forgotPassword">Forgot Password </a></span>
        <span><a href="<?php echo base_url()?>partner-register" style="margin-left:173px">Register</a></span>
        </div>
        </div>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <script>
  // $("#sendotp").click(function(){
    if ($("#formlogin").length > 0) {
      console.log("getting here :::===>");
        $("#formlogin").validate({
    rules: {
      emailnumber: {
            required: true,
            }, 
      password:{
           required:true,
           maxlength: 50,
         }
    },
    messages: {
      emailnumber: {
          required: "Please Enter you registered email or number.",
        }, 
        password:{
          required:"Please enter password",
          maxlength: "The password should less than or equal to 50",
        }
    },
    
    submitHandler: function(form) {
      $.ajax({
        url: "<?php echo base_url('Login/userLogin') ?>",
        type: "POST",
        data: $('#registrationform').serialize(),
        success: function( response ) {
          if(response==1){
            console.log("Getting response here :::::===>",response);
            console.log(response.success);
            $('#otpvarify').show();
            $('#registrationform').hide();
          }else{
          }
        }
      });
    }
    })
    }
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>