<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Enquiry Management
        <small>Edit Enquiry</small>
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
                    
                    <form role="form" action="<?php echo base_url() ?>enquiry/editTask" method="post" id="editTask" role="form">
                        <div class="box-body">
                        <div class="row">

                        <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="taskTitle">Enquiry ID</label>
                                        <input type="text" class="form-control required" value="<?php echo $taskInfo->enquiryId; ?>" id="enquiryId" name="enquiryId" />
                                        <input type="hidden" value="<?php echo $taskInfo->taskId; ?>" name="taskId" id="taskId" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="taskTitle">Mobile Number</label>
                                        <input type="text" class="form-control required" value="<?php echo $taskInfo->mobileNumber; ?>" id="mobileNumber" name="mobileNumber" />
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="taskTitle">Enquiry Date (Optional)</label>
                                        <input type="datetime-local" class="form-control required" value="<?php echo $taskInfo->createdDtm; ?>" id="createdDtm" name="createdDtm" />
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Created By</label>
                                        <textarea class="form-control required" id="companyName" name="companyName"><?php echo $taskInfo->companyName; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="source">Source</label>
                                        <input type="text" class="form-control" value="<?php echo $taskInfo->source; ?>" id="source" name="source" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="medium">Medium (Optional)</label>
                                        <input type="text" class="form-control" value="<?php echo $taskInfo->medium; ?>" id="medium" name="medium" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="campaign">Campaign (Optional)</label>
                                        <input type="text" class="form-control" value="<?php echo $taskInfo->campaign; ?>" id="campaign" name="campaign" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="resiAddress">Res. Address (Optional)</label>
                                        <textarea class="form-control" id="resiAddress" name="resiAddress"><?php echo $taskInfo->resiAddress; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="officeAddress">Office Address (Optional)</label>
                                        <textarea class="form-control" id="officeAddress" name="officeAddress"><?php echo $taskInfo->officeAddress; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remarks">Remarks (Optional)</label>
                                        <textarea class="form-control" id="remarks" name="remarks"><?php echo $taskInfo->remarks; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="where">Where (Optional)</label>
                                        <textarea class="form-control" id="where" name="where"><?php echo $taskInfo->where; ?></textarea>
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