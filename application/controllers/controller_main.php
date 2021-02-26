<?php

class Controller_Main extends Controller
{

    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->sort = "name";
        $this->desc = false;
        $this->data = null;
        $this->page_count = 0;
        $this->cur_page = 1;
    }

    function set_start_default(){
        $this->sort = "name";
        $this->desc = false;
        $this->data = null;
    }

    function set_start_data(){
        if(isset($_COOKIE["ActiveElem"])){
            $this->sort = $_COOKIE["ActiveElem"];
        }

        if(isset($_COOKIE["desc"])){
            $this->desc = intval($_COOKIE["desc"]);
        }

        $this->data = $this->model->get_data($this->sort, $this->desc);
        $this->page_count = $this->model->get_page_count();
    }

    function action_index()
    {

        if($this->model->get_admin_status()){
            header('Location: /mvc/admin/index');
        }

        $this->set_start_default();
        $this->set_start_data();

        if (array_key_exists("page", $_GET)) {
            $this->cur_page = $_GET["page"];
        }
        $this->view->generate('main_view.php', 'template_view.php',
                                $this->data, $this->page_count, $this->cur_page, $this);
    }

    function action_udate_success(){

        $this->set_start_default();
        $this->set_start_data();

        if (array_key_exists("page", $_GET)) {
            $this->cur_page = $_GET["page"];
        }
        $this->view->generate('data_update_view.php', 'template_view.php',
            $this->data, $this->page_count, $this->cur_page, $this);
    }

    function action_update(){

        $name = "";
        $email = "";
        $text = "";
        $status = 0;
        $edit = 0;

        if (isset($_POST["user_name"]) AND isset($_POST["user_email"]) AND isset($_POST["user_task"])) {
            if (!empty($_POST["user_name"]) AND !empty($_POST["user_email"]) AND !empty($_POST["user_task"])) {
                $name = $_POST["user_name"];
                $email = $_POST["user_email"];
                $text =  $_POST["user_task"];
            }
            else{
                throw new Exception('you have empty fields in action_update');
            }
        }
        else{
            throw new Exception('you did not set task fields in action_update');
        }

        $name = htmlspecialchars($name, ENT_QUOTES);;
        $email = htmlspecialchars($email, ENT_QUOTES);
        $text = htmlspecialchars($text, ENT_QUOTES);

        $name = "'" . $name . "'";
        $email = "'" . $email . "'";
        $text = "'" . $text . "'";

        $this->model->update($name, $email, $text, $status, $edit);

        header('Location: /mvc/main/udate_success');
    }
}