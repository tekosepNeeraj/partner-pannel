<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Enquiry Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>enquiry/add"><i class="fa fa-plus"></i> Add New Enquiry</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Enquiry List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>enquiry/enquiryListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>S.No</th>
                        <th>EnquiryId</th>
                        <th>MobileNumber</th>
                        <th>CreatedBy</th>
                        <th>Created On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($records))
                    {
                        $i=1;
                        foreach($records as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $i++;?>.</td>
                        <td><?php echo $record->enquiryId ?></td>
                        <td><?php echo $record->mobileNumber ?></td>
                        <td><?php echo $record->companyName ?></td>
                        <td><?php echo date("d-m-Y", strtotime($record->createdDtm)) ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-success get-detail" href="" mobile="<?php echo $record->mobileNumber;?>" enqury-id="<?php echo $record->taskId;?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'enquiry/edit/'.$record->taskId; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deletetask" href="#" data-taskid="<?php echo $record->taskId; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
    <section class="content">
      
    </section>
</div>


<div id="myModal" class="modal fade" role="dialog">
  <style>
  .modal-padding{
    padding:1.5%;
  }
  </style>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Basic Details</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="offset-md-2 col-md-2">
               <img style="width:90%" src="<?php echo base_url();?>assets/dist/img/avatar.png" class="img-circle" alt="User Image">
            </div>
            <div class="col-md-8">
               <p class="display-mobile"></p>
               <p><i class="fa fa-phone"></i>   <span class="display-mobile"></span></p>
            </div>
        </div>
      </div>
      <div class="modal-header" style="border-top: 1px solid #e5e5e5; padding:5px !important;">
        <h4 class="modal-title">Other Details</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid" id="show-enquiry-detail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "enquiry/taskListing/" + value);
            jQuery("#searchList").submit();
        });
    });


    $('.get-detail').click(function(){
          let enquiry_id = $(this).attr("enqury-id");
          let mobile = $(this).attr("mobile");
    		  $.ajax({
    			url: baseURL+'enquiry/getEquiryDetail',
    			type: 'POST',
    			data: {enquiry_id: enquiry_id},
                beforeSend: function() {
                  $('#loaderint').show();
                },
    			success: function (data){
                    $('.display-mobile').html(mobile);
                    $('#show-enquiry-detail').html(data);
                    $('#loaderint').hide();
                },
            
		     })        
      });


</script>
