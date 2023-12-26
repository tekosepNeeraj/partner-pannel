<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Partner | Sign up</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
   .error{ color:red; } 
  </style>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Partner Register</b><br></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign up</p>
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
          <div class="alert alert-success d-none" id="msg_div">
                <span id="res_message"></span>
            </div>
          <form  id="registrationform" method="post" action="javascript:void(0)">
            <div class="form-group has-feedback">
              <label for="primary_product">Primary Product</label>
              <select class="form-control feedback" name="primary_product" id="primary_product" aria-label="Default select example">
                <option  selected>Select Product</option>
                <option value="1">Auto Loan</option>
                <option value="2">Insurance</option>
                <option value="3">Home Loan</option>
              </select>
            </div>
            <div class="form-group has-feedback">
              <label for="partnertype">Partner Type </label>
              <select class="form-control" name="partnertype" id="partnertype" aria-label="Default select example">
                <option selected>Select Partner Type</option>
                <option value="1">Auto Loan</option>
                <option value="2">Insurance</option>
                <option value="3">Home Loan</option>
              </select>
            </div>
            <div class="form-group has-feedback">
              <label for="pancard">Pancard Detail </label>
              <input type="text" class="form-control" placeholder="Enter Pancard" name="pancard" id="pancard" />
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <label for="">Name</label>
              <input type="text" class="form-control" placeholder="Name" name="name" id="name" />
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <label for="Email Id">Email Id</label>
              <input type="email" class="form-control" placeholder="Email" name="email" id="email" />
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <label for="Pincode">Pincode</label>
              <input type="text" class="form-control" placeholder="Pincode" name="pincode" id="pincode" />
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <label for="city">City </label>
                <select class="form-control" name="city"  id="city" aria-label="Default select example">
                    <option selected>Select City</option>
                    <option value="1">Varanasi</option>
                    <option value="2">Mathura</option>
                    <option value="3">Ayodhya</option>
                </select>
            </div>
            <div class="form-group has-feedback">
              <label for="state">State </label>
                <select class="form-control" name="state" id="state" aria-label="Default select example">
                    <option selected>Select State</option>
                    <option value="1">Delhi</option>
                    <option value="2">UP</option>
                    <option value="3">Hariyana</option>
                </select>
            </div>
            <div class="form-group has-feedback">
              <label for="">Mobile Number</label>
              <input type="text" class="form-control" placeholder="Enter Mobile No." name="mobile" id="mobile" />
              <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-4">    
              <div class="checkbox icheck">
                </div>                      
              </div><!-- /.col -->
              <div class="col-xs-4">
                <input type="submit" id="sendotp" class="btn btn-primary btn-block btn-flat" style="margin-bottom: 14px;" value="Send OTP">
              </div>
              <div class="col-xs-4">
              </div><!-- /.col -->
            </div>
        </form>
        <div class="row" id="otpvarify">
           <form method="post" id="varifingOTP" action="javascript:void(0)"> 
              <div class="col-xs-12">   
                <div class="form-group has-feedback">
                  <input type="text" class="form-control" placeholder="Enter OTP" name="otpnumber" id="otpnumber"/>
                </div>           
            </div>
            <div class="col-xs-4">
              <input type="button" class="btn btn-primary btn-block btn-flat" value="Back" style="margin-left: 52px;">
            </div>
            <div class="col-xs-4">
              <input type="submit" class="btn btn-primary btn-block btn-flat" id="otpSubmit" value="Submit" style="margin-left: 45px;">
            </div>
            </form>  
          </div>
      </div>
    </div>
  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<script>
  $('#otpvarify').hide();
   $('#res_message').hide();
    $('#msg_div').hide();
  // $("#sendotp").click(function(){
    if ($("#registrationform").length > 0) {
      $("#varifymobile").val=($("#mobile").val());
        $("#registrationform").validate({
    rules: {
        primary_product: {
                required: true,
              },  
        partnertype: {
          required: true,
        },  
        mobile:{
            required:true,
            digits:true,
            minlength: 10,
            maxlength:10,
            },
        pancard:{
          required:true,
          maxlength:16,
          minlength:16,
        },
        name:{
          required:true,
        },email:{
          required:true,
          maxlength: 50,
          email: true,
        },
        pincode:{
          required:true,
          maxlength: 50,
        },
        city:{
          required:true,
        },
        state:{
          required:true,
        },

    },
    messages: {
      
        primary_product: {
          required: "Please Select product field.",
        }, 
        partnertype: {
          required: "Please Select Partner field.",
        }, 
        mobile:{
          required: "Please enter contact number",
          minlength: "The contact number should be 10 digits",
          digits: "Please enter only numbers",
          maxlength: "The contact number should be 10 digits",
        },
        pancard:{
          required: "Please enter valid PAN number",
          minlength: "The PAN number should be 16 digits",
          maxlength: "The PAN number should be 16 digits",
        },
        name:{
          required:"Please enter Name"
        },
        email:{
          required:"Please enter a valid email",
          email: "Please enter valid email",
          maxlength: "The email name should less than or equal to 50",
        },
        pincode:{
          required:"Please enter a Pincode",
          maxlength: "The pincode should be 6 digits",
        },
        city:{
          required:"Please Enter your city",
        },
        state:{
          required:"Please Enter your State",
        },

    },
    
    submitHandler: function(form) {
      $.ajax({
        url: "<?php echo base_url('Login/registerMe') ?>",
        type: "POST",
        data: $('#registrationform').serialize(),
        success: function(response) {
          console.log(response.type==1,response.type=='1',response.type=="1",response.type===1,response.type==='1',response.type==="1");
          if(response.redirect!=''){
            console.log("Getting response here :::::===>",response);
            console.log(response.success);
            $('#otpvarify').show();
            $('#registrationform').hide();
            $('#res_message').html(response.msg);
            $('#res_message').show();
            $('#msg_div').removeClass('d-none');
            //  window.location.href =response.redirect;
          
          }else{
            $('#res_message').html(response.msg);
            $('#res_message').show();
            $('#msg_div').removeClass('d-none');
            $('#otpvarify').hide();
            $('#registrationform').show();
          }
        }
      });
    }
    })
    }
</script>
<script>
   $('#res_message').hide();
    $('#msg_div').hide();
    // alert("Hello in otp section");
    console.log("in second section ::::====>");
  if ($("#varifingOTP").length > 0) {
      $("#varifingOTP").validate({
    rules: {
      otpnumber: {
                required: true,
                digits:true,
                minlength: 6,
                maxlength:6,
              }
    },
    messages: {
      otpnumber:{
          required: "Please enter contact number",
          minlength: "The OTP should be 6 digits",
          digits: "Please enter only numbers",
          maxlength: "The OTP should be 6 digits",
        }
    },
    submitHandler: function(form) {
      $.ajax({
        url: "<?php echo base_url('Login/varify_OTP') ?>",
        type: "POST",
        data: $('#varifingOTP').serialize(),
        success: function( response ) {
            console.log("Getting response here :::::===>",response);
            if(response.type==1){
              $('#res_message').html(response.msg);
              $('#res_message').show();
              $('#msg_div').show();
              alert("Hello time");
              setTimeout(function(){
                $('#res_message').hide();
                $('#msg_div').hide();
                
              },1000);
              alert("Hello register");
              window.location.href="http://[::1]/themoneytrunk/partner/login";
            }else{
              $('#res_message').show();
              $('#msg_div').show();
              setTimeout(function(){
                $('#res_message').hide();
                $('#msg_div').hide();
              },2000);
            }
        }
      });}
    })
    }
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>