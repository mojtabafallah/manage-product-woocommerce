<?php
namespace app;
class view
{
    public static function add_view_admin()
    {
        Views::render_view('all_product');


    }
	public static function add_view_admin_slug()
    {
        Views::render_view('all_product_slug');


    }
    public static function add_view_admin_group()
    {
        Views::render_view('all_product_group');


    }
	public static function add_view_admin_report()
    {
        Views::render_view('all_product_report');


    }
}