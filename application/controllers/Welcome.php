<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author David Ticona Saravia <david.ticona.saravia@gmail.com>
 */
class Welcome extends MX_Controller
{
    public function form()
    {
        $this->load->library('form_validation');
        $tpl = "<div class=\"alert alert-{type}\" role=\"alert\">{message}</div>";
        $this->form_validation->set_template($tpl, array('error'=>'danger'));
        $data['message'] = $this->form_validation->get_message();
        $this->form_validation->load_values();
        $this->load->view('myform', $data);
    }
    public function formAjax()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $data['values']  = $this->form_validation->get_values();
        $data['ajax'] = TRUE;
        $this->load->view('myformAjax', $data);
    }
    /**
	 * 
	 */
    public function post()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username','required');
        $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => 'Escreva uma senha no campo %s.'));
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]', 
                array('required' => 'Escreva uma senha no campo %s.', 'matches'=>'Password não coincide'));
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('select[]', 'Subscribe', 'required');
        $this->form_validation->set_rules('accept', 'Accept the terms', 'required');
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_success_delimiters('<p style="color: green">', '</p>');
        $this->form_validation->set_redirect('welcome/form');
        $this->form_validation->set_success_message('Congratulations');
        $this->form_validation->add_success_json('test', '123'); // for ajax request
        $this->form_validation->repopulate_all_except(array('password', 'passconf'));
        $this->form_validation->execute(function(){ 
            log_message('debug', "Success: This was executed before the redirect (or before the response ajax)");
        }, function(){
            log_message('debug', 'Error: This was executed before the redirect (or before the response ajax)');
        });
    }
}
