<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Task Management
        <small>Add / Edit Task</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Enquiry Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addTask" action="<?php echo base_url() ?>enquiry/addNewTask" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="taskTitle">Enquiry ID</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('enquiryId'); ?>" id="enquiryId" name="enquiryId" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="taskTitle">Mobile Number</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('mobileNumber'); ?>" id="mobileNumber" name="mobileNumber" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="taskTitle">Enquiry Date (Optional)</label>
                                        <input type="datetime-local" class="form-control required" value="<?php echo set_value('createdDtm'); ?>" id="createdDtm" name="createdDtm" />
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Created By</label>
                                        <textarea class="form-control required" id="companyName" name="companyName"><?php echo set_value('companyName') ?? "RUPI BAZAAR FINTECH PRIVATE LIMITED"; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="source">Source</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('source') ?? "SMS"; ?>" id="source" name="source" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="medium">Medium (Optional)</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('medium'); ?>" id="medium" name="medium" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="campaign">Campaign (Optional)</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('campaign'); ?>" id="campaign" name="campaign" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="resiAddress">Res. Address (Optional)</label>
                                        <textarea class="form-control" id="resiAddress" name="resiAddress"><?php echo set_value('resiAddress'); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="officeAddress">Office Address (Optional)</label>
                                        <textarea class="form-control" id="officeAddress" name="officeAddress"><?php echo set_value('officeAddress'); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remarks">Remarks (Optional)</label>
                                        <textarea class="form-control" id="remarks" name="remarks"><?php echo set_value('remarks'); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="where">Where (Optional)</label>
                                        <textarea class="form-control" id="where" name="where"><?php echo set_value('where'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
</div>