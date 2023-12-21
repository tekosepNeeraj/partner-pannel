<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Enquiry extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Task_model', 'tm');
        $this->isLoggedIn();
        $this->module = 'Task';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('enquiry/enquiryListing');
    }
    
    /**
     * This function is used to load the task list
     */

    function enquiryListing()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = '';
            if(!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->tm->taskListingCount($searchText);

			$returns = $this->paginationCompress ( "enquiryListing/", $count, 10 );
            
            $data['records'] = $this->tm->taskListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'SMS Manager : Task';
            
            $this->loadViews("task/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'SMS Manager : Add New Task';

            $this->loadViews("task/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewTask()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('enquiryId','EnquiryId','trim|required|max_length[40]|min_length[4]|is_unique[tbl_task.enquiryId]');
            $this->form_validation->set_rules('mobileNumber','Mobile Number','trim|required|max_length[12]|min_length[10]|is_unique[tbl_task.mobileNumber]');
            $this->form_validation->set_rules('companyName','Created By','trim|required|max_length[256]');

            $this->form_validation->set_rules('source','Source','trim|required|max_length[256]');
            $this->form_validation->set_rules('medium','Medium','trim|max_length[256]');
            $this->form_validation->set_rules('campaign','campaign','trim|max_length[256]');
            $this->form_validation->set_rules('resiAddress','Resi Address','trim|max_length[256]');
            $this->form_validation->set_rules('officeAddress','Office Address','trim|max_length[256]');
            $this->form_validation->set_rules('remarks','Remarks','trim|max_length[256]');
            $this->form_validation->set_rules('where','Where','trim|max_length[256]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $enquiryId = $this->security->xss_clean($this->input->post('enquiryId'));
                $mobileNumber = $this->security->xss_clean($this->input->post('mobileNumber'));
                $companyName = $this->security->xss_clean($this->input->post('companyName'));
                $createdDate = $this->security->xss_clean($this->input->post('createdDtm'));

                $source = $this->security->xss_clean($this->input->post('source'));
                $medium = $this->security->xss_clean($this->input->post('medium'));
                $campaign = $this->security->xss_clean($this->input->post('campaign'));
                $resiAddress = $this->security->xss_clean($this->input->post('resiAddress'));
                $officeAddress = $this->security->xss_clean($this->input->post('officeAddress'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $where = $this->security->xss_clean($this->input->post('where'));

                if($createdDate){
                    $cDate=$createdDate;
                }else{
                    $cDate=date('Y-m-d H:i:s');
                }
                $taskInfo = array('enquiryId'=>$enquiryId, 'companyName'=>$companyName, 'mobileNumber'=>$mobileNumber, 'source'=>$source, 'medium'=>$medium, 'campaign'=>$campaign, 'resiAddress'=>$resiAddress, 'officeAddress'=>$officeAddress, 'remarks'=>$remarks, 'where'=>$where, 'createdBy'=>$this->vendorId, 'createdDtm'=>$cDate);
                $result = $this->tm->addNewTask($taskInfo);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Enquiry created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Enquiry creation failed');
                }
                
                redirect('enquiry/enquiryListing');
            }
        }
    }


    public function getEquiryDetail(){
        $enquiry_id=$this->input->post('enquiry_id');
        $data=$this->tm->getTaskInfo($enquiry_id);
        $createdDate=date('d-M-Y H:i:s',strtotime($data->createdDtm));
        $html=' <div class="row">
        <div class="col-md-3 modal-padding">Enquiry ID:</div>
        <div class="col-md-2 modal-padding ml-auto"><span class="badge btn-success">'.$data->enquiryId.'</span></div>
        <div class="col-md-3 modal-padding">Created On:</div>
        <div class="col-md-4 modal-padding ml-auto">'.$createdDate.'</div>
    </div>
    <div class="row">
        <div class="col-md-3 modal-padding ml-auto">Source:</div>
        <div class="col-md-2 modal-padding ml-auto">'.$data->source.'</div>
        <div class="col-md-3 modal-padding ml-auto">Medium:</div>
        <div class="col-md-4 modal-padding ml-auto">'.$data->medium.'</div>
    </div>

    <div class="row">
        <div class="col-md-3 modal-padding ml-auto">Campaign:</div>
        <div class="col-md-2 modal-padding ml-auto">'.$data->campaign.'</div>
        <div class="col-md-3 modal-padding ml-auto">Created By:</div>
        <div class="col-md-4 modal-padding ml-auto">'.$data->companyName.'</div>
    </div>

    <div class="row">
        <div class="col-md-3 modal-padding ml-auto">Resi. Address:</div>
        <div class="col-md-2 modal-padding ml-auto">'.$data->resiAddress.'</div>
    </div>

    <div class="row">
        <div class="col-md-3 modal-padding ml-auto">Office Address:</div>
        <div class="col-md-2 modal-padding ml-auto">'.$data->officeAddress.'</div>
    </div>

    <div class="row">
        <div class="col-md-3 modal-padding ml-auto">Remarks:</div>
        <div class="col-md-2 modal-padding ml-auto">'.$data->remarks.'</div>
    </div>

    <div class="row">
        <div class="col-md-3 modal-padding ml-auto">Where:</div>
        <div class="col-md-2 modal-padding ml-auto">'.$data->where.'</div>
    </div>';
        echo $html;
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($taskId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($taskId == null)
            {
                redirect('enquiry/enquiryListing');
            }
            
            $data['taskInfo'] = $this->tm->getTaskInfo($taskId);

            $this->global['pageTitle'] = 'SMS Manager : Edit Enquiry';
            
            $this->loadViews("task/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editTask()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $taskId = $this->input->post('taskId');
            
            $this->form_validation->set_rules('enquiryId','EnquiryId','trim|required|max_length[40]|min_length[4]');
            $this->form_validation->set_rules('mobileNumber','Mobile Number','trim|required|max_length[12]|min_length[10]');
            $this->form_validation->set_rules('companyName','Created By','trim|required|max_length[256]');

            $this->form_validation->set_rules('source','Source','trim|required|max_length[256]');
            $this->form_validation->set_rules('medium','Medium','trim|max_length[256]');
            $this->form_validation->set_rules('campaign','campaign','trim|max_length[256]');
            $this->form_validation->set_rules('resiAddress','Resi Address','trim|max_length[256]');
            $this->form_validation->set_rules('officeAddress','Office Address','trim|max_length[256]');
            $this->form_validation->set_rules('remarks','Remarks','trim|max_length[256]');
            $this->form_validation->set_rules('where','Where','trim|max_length[256]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($taskId);
            }
            else
            {
                $enquiryId = $this->security->xss_clean($this->input->post('enquiryId'));
                $mobileNumber = $this->security->xss_clean($this->input->post('mobileNumber'));
                $companyName = $this->security->xss_clean($this->input->post('companyName'));
                $createdDate = $this->security->xss_clean($this->input->post('createdDtm'));

                $source = $this->security->xss_clean($this->input->post('source'));
                $medium = $this->security->xss_clean($this->input->post('medium'));
                $campaign = $this->security->xss_clean($this->input->post('campaign'));
                $resiAddress = $this->security->xss_clean($this->input->post('resiAddress'));
                $officeAddress = $this->security->xss_clean($this->input->post('officeAddress'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $where = $this->security->xss_clean($this->input->post('where'));

                if($createdDate){
                    $cDate=$createdDate;
                }else{
                    $cDate=date('Y-m-d H:i:s');
                }
                $taskInfo = array('enquiryId'=>$enquiryId, 'companyName'=>$companyName, 'mobileNumber'=>$mobileNumber, 'source'=>$source, 'medium'=>$medium, 'campaign'=>$campaign, 'resiAddress'=>$resiAddress, 'officeAddress'=>$officeAddress, 'remarks'=>$remarks, 'where'=>$where, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'),'createdDtm'=>$cDate);
                
                $result = $this->tm->editTask($taskInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Enquiry updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Enquriy updation failed');
                }
                
                redirect('enquiry/enquiryListing');
            }
        }
    }
}

?>