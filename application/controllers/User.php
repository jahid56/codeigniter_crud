<?php
/*
 * This file contains the Model.
 * 
 * @php version 5.6
 * @author Jahid Mahmud
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // load the model
        $this->load->model('user_model');
        $this->load->library('file_processing');
    }

    public function index() {
        $data = array();
        $data['pageTitle'] = "Manage User";

        //get all user data
        $data['all_data'] = $this->user_model->getAll();

        $this->load->view('user/manage', $data);
    }

    public function create() {
        $data = array();
        $data['pageTitle'] = " User Form";


        if ($this->input->post('submit')) {
            // write the validation rule
            $this->form_validation
                    ->set_rules('name', 'Name', 'trim|required')
                    ->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[user.email]')
                    ->set_rules('phone', 'Phone', 'trim|required')
                    ->set_rules('password', 'Password', 'required|matches[re_password]')
                    ->set_rules('re_password', 'Confirm Password', 'required')
                    ->set_rules('image', 'Image', 'callback_file_validate[no.image.jpg,jpeg,gif,png]');


            // check the validation
            if ($this->form_validation->run()) {
                $addData = array();
                //photo upload
                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]) {
                    $photo = $this->file_processing->image_upload('image', './assets/image/', 'size[300,600]');
                    if (!empty($photo)) {
                        img_resize('./assets/image/' . $photo, './assets/image/' . $photo, array('width' => 300, 'height' => 300, 'crop' => TRUE));
                        img_resize('./assets/image/' . $photo, './assets/image/' . 'thumbs/' . $photo, array('width' => 100, 'height' => 100, 'crop' => TRUE));
                    }
                    $addData['image'] = $photo;
                }

                $addData['name'] = $this->input->post('name');
                $addData['email'] = $this->input->post('email');
                $addData['phone'] = $this->input->post('phone');
                $addData['password'] = md5($this->input->post('password'));
                $addData['added'] = date('Y-m-d H:i:s');

                if ($this->user_model->create($addData)) {
                    $this->session->set_flashdata('success_msg', 'Add Successfully!!');
                    redirect('user');
                } else
                    $data['error'] = mysql_error();
            }else {
                $data['error'] = validation_errors();
            }
        }


        $this->load->view('user/create', $data);
    }

    //Edit user
    public function edit($id) {
        $data = array();
        $data['pageTitle'] = " Edit User";

        $data['getData'] = $getData = $this->user_model->get_single_data($id);

        if ($this->input->post('submit')) {
            // write the validation rule
            $this->form_validation
                    ->set_rules('name', 'Name', 'trim|required')
                    ->set_rules('email', 'Email Address', 'trim|required|valid_email')
                    ->set_rules('phone', 'Phone', 'trim|required')
                    ->set_rules('image', 'Image', 'callback_file_validate[no.image.jpg,jpeg,gif,png]');
            if ($this->input->post('password')) {
                $this->form_validation
                        ->set_rules('password', 'Password', 'required|matches[re_password]')
                        ->set_rules('re_password', 'Confirm Password', 'required');
            }
            // check the validation
            if ($this->form_validation->run()) {
                $addData = array();
                //photo upload
                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]) {
                    $photo = $this->file_processing->image_upload('image', './assets/image/', 'size[300,600]');
                    if (!empty($photo)) {
                        $this->file_processing->delete_file($getData->image, './assets/image/');
                        $this->file_processing->delete_file($getData->image, './assets/image/thumbs/');
                    }
                    if (!empty($photo)) {
                        img_resize('./assets/image/' . $photo, './assets/image/' . $photo, array('width' => 300, 'height' => 300, 'crop' => TRUE));
                        img_resize('./assets/image/' . $photo, './assets/image/' . 'thumbs/' . $photo, array('width' => 100, 'height' => 100, 'crop' => TRUE));
                    }
                    $addData['image'] = $photo;
                }

                $addData['name'] = $this->input->post('name');
                $addData['email'] = $this->input->post('email');
                $addData['phone'] = $this->input->post('phone');

                if ($this->input->post('password')) {
                    $addData['password'] = md5($this->input->post('password'));
                }

                if ($this->user_model->update($addData, $id)) {
                    $this->session->set_flashdata('success_msg', 'Update Successfully!!');
                    redirect('user');
                } else
                    $data['error'] = mysql_error();
            }
        }

        $this->load->view('user/edit', $data);
    }

    public function view($id) {
        $data = array();
        $data['pageTitle'] = "View User Information";

        //get a user data
        $data['getData'] = $getData = $this->user_model->get_single_data($id);

        $this->load->view('user/view', $data);
    }

    public function delete($id) {
        $getData = $this->user_model->get_single_data($id);
        if ($getData->image) {
            $this->file_processing->delete_file($getData->image, './assets/image/');
            $this->file_processing->delete_file($getData->image, './assets/image/thumbs/');
        }
        if ($this->user_model->delete($id)) {
            $this->session->set_flashdata('success_msg', 'Successfully Deleted!!');
            redirect('user');
        }
    }

    // file validation
    public function file_validate($fieldValue, $params) {
        // get the parameter as variable
        list($require, $fieldName, $type) = explode('.', $params);

        // get the type as array
        $types = explode(',', $type);

        // get the file field name
        $filename = $_FILES[$fieldName]['name'];

        if (is_array($filename)) {
            // filter the array
            $filename = array_filter($filename);

            if (count($filename) == 0 && $require == 'yes') {
                $this->form_validation->set_message('file_validate', 'The %s field is required');
                return FALSE;
            } elseif ($type != '' && count($filename) != 0) {
                foreach ($filename as $aFile) {
                    // get the extention
                    $ext = strtolower(substr(strrchr($aFile, '.'), 1));

                    if (!in_array($ext, $types)) {
                        $this->form_validation->set_message('file_validate', 'The %s field must be ' . implode(' OR ', $types) . ' !!');
                        return FALSE;
                    }
                }
                return true;
            } else {
                return TRUE;
            }
        } else {
            if ($filename == '' && $require == 'yes') {
                $this->form_validation->set_message('file_validate', 'The %s field is required');
                return FALSE;
            } elseif ($type != '' && $filename != '') {
                // get the extention
                $ext = strtolower(substr(strrchr($filename, '.'), 1));

                if (!in_array($ext, $types)) {
                    $this->form_validation->set_message('file_validate', 'The %s field must be ' . implode(' OR ', $types) . ' !!');
                    return FALSE;
                }
            } else
                return TRUE;
        }
    }

}
