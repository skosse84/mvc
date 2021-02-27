<?php


class Model_Main extends Model
{
    function __construct($user = "guest", $pass = "1")
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->host = "localhost";
        $this->db = "tasks";

//		$this->user = "alexdz";
//      $this->pass = "Ww221923";
//      $this->host = "mysql.zzz.com.ua";
//      $this->db = "alexdz";
    }

    public function get_data($sort = "name", $desc = false, $start_index = 0, $limit_length = 3)
    {
        $data = [];
        $query = "";
        $query_desc = "ASC";
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        if ($desc) {
            $query_desc = "DESC";
        }

        $query = "SELECT * FROM data ORDER BY $sort " . $query_desc . " LIMIT $start_index, $limit_length";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

        if ($result) {
            $rows = mysqli_num_rows($result); // количество полученных строк

            for ($i = 0; $i < $rows; ++$i) {
                $row = mysqli_fetch_row($result);
                $data[$i]["id"] = $row[0];
                $data[$i]["name"] = $row[1];
                $data[$i]["email"] = $row[2];
                $data[$i]["text"] = $row[3];
                $data[$i]["status"] = $row[4];
                $data[$i]["edit"] = $row[5];
            }
        }

        mysqli_close($link);

        return $data;
    }

    public function get_page_count()
    {

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "SELECT COUNT(*) FROM data";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        $page_count = mysqli_fetch_row($result);

        mysqli_close($link);

        return intval((ceil($page_count[0] / 3)));
    }

    function update($name, $email, $text, $status = 0, $edit = 0)
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "INSERT INTO `data` (`name`,`email`,`text`,`status`,`edit`)  VALUES (?, ?, ?, ?, ?);";

        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'sssii', $name, $email, $text, $status, $edit);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_close($link);
    }

    function change($id, $name, $email, $text, $status = 0)
    {
        $edit = $this->get_edit_state($id);

        if (("'" . $this->get_task_text($id) . "'") != $text) {
            $edit = 1;
        }

        $query = "UPDATE `data`
                  SET
                  `name`={$name},
                  `email`={$email},
                  `text`={$text},
                  `status`={$status},
                  `edit`={$edit}
                  WHERE `id`={$id};";

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        mysqli_close($link);
    }

    function delete($id)
    {
        $query = "DELETE FROM `data` WHERE id={$id};";

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        mysqli_close($link);
    }

    function get_task_text($id)
    {
        $text = "";

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "SELECT text FROM data WHERE id=$id";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if ($result->num_rows > 0) {
            $text = mysqli_fetch_row($result)[0];
        }

        mysqli_close($link);

        return $text;
    }

    function get_edit_state($id)
    {
        $edit = 0;

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "SELECT edit FROM data WHERE id=$id";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if ($result->num_rows > 0) {
            $edit = mysqli_fetch_row($result)[0];
        }

        mysqli_close($link);

        return $edit;
    }

    function checkAdminAccess($login, $pass)
    {
        $access = 0;

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "SELECT pass FROM users WHERE name='$login'";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if ($result->num_rows > 0) {
            $pass_from_db = mysqli_fetch_row($result)[0];
            if ($pass_from_db == $pass) {
                $access = 1;
            } else {
                $access = 0;
            }
        }

        mysqli_close($link);

        return $access;

    }

    function get_admin_status()
    {

        $status = 0;

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "SELECT status FROM users WHERE name='admin'";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if ($result->num_rows > 0) {
            $status = mysqli_fetch_row($result)[0];
        } else {
            throw new Exception('you not have admin record');
        }

        mysqli_close($link);

        return $status;
    }

    function set_admin_status($status = 1)
    {

        if (($status != 1) AND ($status != 0)) {
            throw new Exception('Incorrect admin status!');
        }

        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db)
        or die("Error " . mysqli_error($link));

        $query = "UPDATE `users` SET status = $status WHERE `name` = 'admin'";

        mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

        mysqli_close($link);

    }
}
