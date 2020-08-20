<?php


class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->sort = "name";
        $this->desc = false;
        $this->data = null;
        $this->page_count = 0;
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
            $this->set_start_default();
            $this->set_start_data();
            $this->view->generate('admin_view.php', 'template_view.php',
                $this->data, $this->page_count, $this);
        }
        elseif (isset($_POST["login"]) AND isset($_POST["pass"])) {
            if (!empty($_POST["login"]) AND !empty($_POST["pass"])) {
                if ($this->model->checkAdminAccess($_POST["login"], $_POST["pass"])) {
                    $this->model->set_admin_status(1);
                    $this->set_start_default();
                    $this->set_start_data();
                    $this->view->generate('admin_view.php', 'template_view.php',
                        $this->data, $this->page_count, $this);
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

        $this->view->generate('data_update_admin_view.php', 'template_view.php',
            $this->data, $this->page_count, $this);
    }

    function action_access_denied(){

        $this->set_start_default();
        $this->set_start_data();

        $this->view->generate('access_denied_view.php', 'template_view.php',
            $this->data, $this->page_count, $this);
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
                throw new Exception('you have empty fields in action_change');
            }
        }
        else{
            throw new Exception('you did not set task fields in action_change');
        }

        $name = htmlspecialchars($name, ENT_QUOTES);
        $email = htmlspecialchars($email, ENT_QUOTES);
        $text = htmlspecialchars($text, ENT_QUOTES);

        $name = "'" . $name . "'";
        $email = "'" . $email . "'";
        $text = "'" . $text . "'";

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

            $name = "'" . $name . "'";
            $email = "'" . $email . "'";
            $text = "'" . $text . "'";

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