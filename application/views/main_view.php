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


<?php
$GLOBALS["action_view"] = '/mvc/main/update';
include 'general_view.php';

$col_row = count($data);
$page_current = $cur_page;

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
echo '<script src="../../../mvc/js/main_view.js"></script>';
?>


