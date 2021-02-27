<?php


class Controller_Admin extends Controller_Main
{
    function __construct()
    {
        parent::__construct();
    }


    function action_index()
    {
        if($this->model->get_admin_status()){
            $this->set_start_default();
            $this->set_start_data();
            if (array_key_exists("page", $_GET)) {
                $this->cur_page = $_GET["page"];
            }
            $this->view->generate('admin_view.php', 'template_view.php',
                $this->data, $this->page_count, $this->cur_page, $this);
        }
        elseif (isset($_POST["login"]) AND isset($_POST["pass"])) {
            if (!empty($_POST["login"]) AND !empty($_POST["pass"])) {
                if ($this->model->checkAdminAccess($_POST["login"], $_POST["pass"])) {
                    $this->model->set_admin_status(1);
                    $this->set_start_default();
                    $this->set_start_data();
                    if (array_key_exists("page", $_GET)) {
                        $this->cur_page = $_GET["page"];
                    }
                    $this->view->generate('admin_view.php', 'template_view.php',
                        $this->data, $this->page_count, $this->cur_page, $this);
                }
                else{
                    header('Location: /mvc/admin/access_denied');
                }
            }
            else{
                header('Location: /mvc/admin/access_denied');
            }
        }
        else{
            header('Location: /mvc/admin/access_denied');
        }
    }

    function action_out()
    {
        $this->model->set_admin_status(0);
        header('Location: /mvc/');
    }

    function action_udate_success(){
        $this->set_start_default();
        $this->set_start_data();

        if (array_key_exists("page", $_GET)) {
            $this->cur_page = $_GET["page"];
        }

        $this->view->generate('data_update_admin_view.php', 'template_view.php',
            $this->data, $this->page_count, $this->cur_page, $this);
    }

    function action_access_denied(){

        $this->set_start_default();
        $this->set_start_data();

        if (array_key_exists("page", $_GET)) {
            $this->cur_page = $_GET["page"];
        }

        $this->view->generate('access_denied_view.php', 'template_view.php',
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

        $name = htmlspecialchars($name, ENT_QUOTES);
        $email = htmlspecialchars($email, ENT_QUOTES);
        $text = htmlspecialchars($text, ENT_QUOTES);


        $this->model->update($name, $email, $text, $status, $edit);

        header('Location: /mvc/admin/udate_success');
    }

    function action_change(){

        $id = "";
        $name = "";
        $email = "";
        $text = "";
        $status = 0;
        $delete = "0";

        if(!$this->model->get_admin_status()){
            header('Location: /mvc/admin/access_denied');
        }
        else{

            if (isset($_POST["id_user"]) AND isset($_POST["delete"]) AND isset($_POST["user_name"])
                AND isset($_POST["user_email"]) AND isset($_POST["user_task"])) {
                if (!empty($_POST["id_user"]) AND !empty($_POST["user_name"])
                    AND !empty($_POST["user_email"]) AND !empty($_POST["user_task"])) {
                    $id = $_POST["id_user"];
                    $delete = $_POST["delete"];
                    $name = $_POST["user_name"];
                    $email = $_POST["user_email"];
                    $text =  $_POST["user_task"];
                    if(isset($_POST["task_status"])){
                        $status = 1;
                    }
                }
                else{
                    throw new Exception('you have empty fields in action_change');
                }
            }
            else{
                throw new Exception('you did not set task fields in action_change');
            }

            $name = htmlspecialchars($name, ENT_QUOTES);
            $email = htmlspecialchars($email, ENT_QUOTES);
            $text = htmlspecialchars($text, ENT_QUOTES);

            if(intval($delete)){
                $this->model->delete($id);
            }
            else{
                $this->model->change($id, $name, $email, $text, $status);
            }

            header('Location: /mvc/admin/udate_success');
        }

    }

}