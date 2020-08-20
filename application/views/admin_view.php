<div class="wrap_flex flex-right">
    <form method="post" action="/mvc/admin/out" class="w-25">
        <button type="submit" class="btn yellow enter_button w-75"><span class="text_blue">Out</span></button>
    </form>
</div>



<h1 class="main_header">Task manager</h1>
<h1 class="main_header">ADMIN ACCESS</h1>


<form method="post" action="/mvc/admin/update">
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

<script>
    let items = document.querySelectorAll(".dropdown-item");
    let ActiveElem = getCookie("ActiveElem");
    let desc = parseInt(getCookie("desc"));


    if (desc) {
        sortButton.classList.remove("green");
        sortButton.classList.add("yellow");
        sortButton.classList.add("text_blue");
    }

    id_delete.addEventListener("click", (e) => {
        e.target.form.delete.value = "1";
        e.target.form.submit();
    });

    sortButton.addEventListener("click", (e) => {
        if (e.target.classList.contains("green")) {
            e.target.classList.remove("green");
            e.target.classList.add("yellow");
            e.target.classList.add("text_blue");
            e.target.classList.remove("text_white");
            document.cookie = "desc=1";
            location.reload();
        } else {
            e.target.classList.remove("yellow");
            e.target.classList.add("green");
            e.target.classList.add("text_white");
            e.target.classList.remove("text_blue");
            document.cookie = "desc=0";
            console.log(getCookie("desc"));
            location.reload();
        }
    });

    function clearActive() {
        items.forEach((val) => {
            val.classList.remove("active");
        })
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    if (ActiveElem != undefined) {
        clearActive();
        items.forEach((val) => {
            if (val.innerText == ActiveElem) {
                val.classList.add("active");
            }
        })
    }

    items.forEach((val) => {
        val.addEventListener("click", (e) => {
            clearActive();
            e.target.classList.add("active");
            document.cookie = "ActiveElem=" + e.target.innerText;
            location.reload();
        })
    })
</script>

