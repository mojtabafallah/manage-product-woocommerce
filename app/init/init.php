<?php

namespace app\init;

use app\view;

class init
{

    public static function create_menu()
    {
        add_menu_page(
            'مدیریت محصولات',
            'مدیریت محصولات',
            'manage_options',
            'manage-product',

            array(view::class, 'add_view_admin'),
            'dashicons-tag');


			add_menu_page(
            'مدیریت نامک محصولات',
            'مدیریت نامک محصولات',
            'manage_options',
            'manage-product_slug',
            array(view::class, 'add_view_admin_slug'),
            'dashicons-tag');

        add_menu_page(
            'گروه بندی برای دسته بندی ها',
            'گروه بندی برای دسته بندی ه',
            'manage_options',
            'manage-product_group',
            array(view::class, 'add_view_admin_group'),
            'dashicons-tag');



			add_menu_page(
            'گزارش',
            'گزارش',
            'manage_options',
            'manage-product_report',
            array(view::class, 'add_view_admin_report'),
            'dashicons-tag');
    }
}