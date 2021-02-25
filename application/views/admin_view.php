<div class="wrap_flex flex-right">
    <form method="post" action="/mvc/admin/out" class="w-25">
        <button type="submit" class="btn yellow enter_button w-75"><span class="text_blue">Out</span></button>
    </form>
</div>


<h1 class="main_header">ADMIN ACCESS</h1>

<?php
$GLOBALS["action_view"] = '/mvc/admin/update';
include 'general_view.php';
?>




<?php
$col_row = count($data);
$page_current = 1;


if (array_key_exists("page", $_GET)) {
    $page_current = $_GET["page"];
}

for ($i = 0; $i < $col_row; $i++) {
    $checked = "";
    if ($data[$i]["status"] == 1) {
        echo '<form class="task green" method="post" action="/mvc/admin/change">';
        $checked = "checked";
    } else {
        echo '<form class="task yellow" method="post" action="/mvc/admin/change">';
    }
    echo "
      <input type='hidden' name='id_user' value=\"{$data[$i]["id"]}\">
      <input type='hidden' name='delete' value=\"0\">
      <div class=\"form-row\">
          <div class=\"form-group col-md-6\">
            <label for=\"id_user_name\">Name:</label>
            <input type=\"text\" class=\"form-control\" id=\"id_user_name\"
                            name=\"user_name\" value=\"{$data[$i]["name"]}\">
          </div>
          <div class=\"form-group col-md-6\">
            <label for=\"user_email\">Email:</label>
            <input type=\"text\" class=\"form-control\" id=\"id_user_email\"
                            name=\"user_email\" value=\"{$data[$i]["email"]}\">
          </div>
      </div>
      <div class=\"form-row\">
          <div class=\"input-group col-md-12 pb-3\">    
                      <input type=\"text\" class=\"form-control w-95\" id=\"id_user_task\"
                            name=\"user_task\" value=\"{$data[$i]["text"]}\" >                   
              <div class=\"input-group-append\">
                <div class=\"input-group-text\">
                    <input type=\"checkbox\" class=\"\" id=\"id_status\"
                            name=\"task_status\" value={$data[$i]["status"]} {$checked}>
                </div>
              </div>
          </div>
      </div>
      <div class=\"form-row pb-4\">
          <div class=\"form-group col-md-6\">  
            <input type=\"submit\" class=\"form-control\" id=\"id_save\" value=\"Save changes\"/>
          </div>
          <div class=\"form-group col-md-6\">  
            <input type=\"button\" class=\"form-control\" id=\"id_delete\" value=\"Delete task\"/>
          </div>
      </div>
    ";
    if ($data[$i]["edit"] == 1) {
        echo "<div class='admin_edit blue text_white'><div class='circle_text'>edit by admin</div></div>";
    }
    echo "</form>";
}

echo "<div class=\"wrap_pagination\">";
for ($i = 1; $i < $page_count + 1; $i++) {
    if ($i == $page_current) {
        echo "<a class=\"pag_link pag_active\" href='./index?page=$i'>
                $i
              </a>";
    } else {
        echo "<a class=\"pag_link\" href='./index?page=$i'>
                $i
              </a>";
    }

}
echo "</div>";


?>

<script  src="../../js/admin_view.js">

</script>

