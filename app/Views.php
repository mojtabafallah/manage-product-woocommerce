<?php
namespace app;

class Views
{
    public static function render_view($file_name)
    {
        include (PLUGIN_URI. '/view/admin/'.$file_name. '.php');
    }
}