<div class="wrap_flex flex-right">
    <form method="post" action="/mvc/admin/index" class="w-25">
        <div class="form-group">
            <input type="text" class="form-control w-75" id="id_login"
                   name="login" placeholder="Enter login" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control w-75" id="id_pass"
                   name="pass" placeholder="Enter Password" required>
        </div>
        <button type="submit" class="btn yellow enter_button w-75"><span class="text_blue">Enter</span></button>
    </form>
</div>


<h1 class="main_header">Task manager</h1>


<form method="post" action="/mvc/main/update">
    <div class="form-group">
        <label for="user_name">Name:</label>
        <input type="text" class="form-control" id="user_name" name="user_name" required>
    </div>
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" name="user_email" required>
    </div>
    <div class="form-group">
        <label for="task_text">Task text:</label>
        <input type="text" class="form-control" id="task_text" name="user_task" required>
    </div>
    <button type="submit" class="btn btn-primary w-100 my-3">Add task</button>
</form>

<div class="wrap_circle">
    <div class="yellow circle">
        <div class="circle_text">Status - in progress</div>
    </div>
    <div class="green circle">
        <div class="circle_text">Status - done</div>
    </div>
    <div class="blue circle">
        <div class="circle_text">Status - admin edit</div>
    </div>
</div>

<div class="wrap_flex my-3">
    <div class="dropdown w-75">
        <button type="button" class="btn btn-primary dropdown-toggle  w-100" data-toggle="dropdown">
            Sort task
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item active" href="#">Name</a>
            <a class="dropdown-item" href="#">Email</a>
            <a class="dropdown-item" href="#">Status</a>
        </div>
    </div>
    <button type="button" class="btn btn-primary w-25 green text_white" id="sortButton">Sort reverse</button>
</div>


<?php
$col_row = count($data);
$page_current = 1;


if (array_key_exists("page", $_GET)) {
    $page_current = $_GET["page"];
}

for ($i = 0; $i < $col_row; $i++) {
    if ($data[$i]["status"] == 1) {
        echo "<div class=\"task green\">";
    } else {
        echo "<div class=\"task yellow\">";
    }
    echo "<b>Name:</b> {$data[$i]["name"]}; <b>Email:</b> {$data[$i]["email"]}; <b>Text:</b> {$data[$i]["text"]};";
    if ($data[$i]["edit"] == 1) {
        echo "<div class='admin_edit blue text_white'><div class='circle_text'>edit by admin</div></div>";
    }
    echo "</div>";
}

echo "<div class=\"wrap_pagination\">";
for ($i = 1; $i < $page_count + 1; $i++) {
    if ($i == $page_current) {
        echo "<a class=\"pag_link pag_active\" href='./?page=$i'>
                $i
              </a>";
    } else {
        echo "<a class=\"pag_link\" href='./?page=$i'>
                $i
              </a>";
    }

}
echo "</div>";
?>

<script src="../../js/main_view.js">

</script>
