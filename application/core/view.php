<?php

class View
{

    function generate($content_view, $template_view, $data = null, $page_count = null, $controller = null)
    {
        include 'application/views/'.$template_view;
    }
}