<h1 class="main_header">Task manager</h1>
<form method="post" action='<?php$GLOBALS["action_view"]?>'>
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