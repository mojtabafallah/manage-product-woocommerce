<!-- Latest compiled and minified CSS -->
<link
        rel="stylesheet"
        href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css"
        integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe"
        crossorigin="anonymous"/>

<!-- Latest compiled and minified JavaScript -->
<script
        src="https://cdn.rtlcss.com/bootstrap/v4.5.3/js/bootstrap.min.js"
        integrity="sha384-VmD+lKnI0Y4FPvr6hvZRw6xvdt/QZoNHQ4h5k0RL30aGkR9ylHU56BzrE2UoohWK"
        crossorigin="anonymous"></script>
<style>
    body {
        font-family: 'IRANSans';
    }
</style>
<?php
include 'Layout/main_layout.php';
if(isset($_POST['save_key_group']))
{
    /*****save data grouped ******/

    // get the option
    // $data = get_option( '_key_group' );
// add new data to the option
    $key_group=$_POST['grouped'];

// save it back to the db
    update_option( '_key_group', $key_group );


    /*****end save data grouped ******/
}

if (isset($_POST['submit_price'])) {


    foreach ($_POST as $key => $items) {
        $pos = strpos($key, '-');
        $id = substr($key, $pos + 1);
        $flag_fill_item=false;

        if (intval($id)) {

            /*   if ($key == 'plus_s-' . $id) {
                   $plus = $items;
                   $price = get_post_meta($id, '_price', true);
                   if($price=="تماس بگیرید") $price=0;

                   $updated_price = $price + $plus;
                   update_post_meta($id, '_price', $updated_price);
                   update_post_meta($id, '_sale_price', $updated_price);
               }
               if ($key == 'mines_s-' . $id) {
                   $min = $items;
                   $price = get_post_meta($id, '_price', true);
                   if($price=="تماس بگیرید") $price=0;
                   $updated_price = $price - $min;
                   update_post_meta($id, '_price', $updated_price);
                   update_post_meta($id, '_sale_price', $updated_price);
               }*/
            if ($key == 'price-' . $id) {
                if (isset($items)) {



                    update_post_meta($id, '_price', $items);
                    update_post_meta($id, '_regular_price', $items);
                    update_post_meta($id, '_sale_price', null);





                }

            }
            if ($key == 'plus_r-' . $id) {
                $plus = $items;
                $price = get_post_meta($id, '_price', true);

                if ($price == "تماس بگیرید") $price = 0;

                $updated_price = $price + $plus;
                $time = current_time('mysql');

                wp_update_post(
                    array(
                        'ID' => $id,
                        'post_date' => $time,
                        'post_date_gmt' => get_gmt_from_date($time)
                    )
                );
                update_post_meta($id, '_price', $updated_price);
                update_post_meta($id, '_regular_price', $updated_price);
                update_post_meta($id, '_sale_price', null);
                if($plus != 0)
                {
                    add_post_meta($id, '_data_for_chart', ['value' => $updated_price, 'date' => get_gmt_from_date($time)]);
                }


            }
            if ($key == 'mines_r-' . $id) {
                $min = $items;
                $price = get_post_meta($id, '_price', true);
                if ($price == "تماس بگیرید") $price = 0;
                $updated_price = $price - $min;
                if ($updated_price > 0) {
                    $time = current_time('mysql');

                    wp_update_post(
                        array(
                            'ID' => $id,
                            'post_date' => $time,
                            'post_date_gmt' => get_gmt_from_date($time)
                        )
                    );
                    update_post_meta($id, '_price', $updated_price);
                    update_post_meta($id, '_regular_price', $updated_price);
                    update_post_meta($id, '_sale_price', null);
                    if($min !=0)
                    {
                        add_post_meta($id, '_data_for_chart', ['value' => $updated_price, 'date' => get_gmt_from_date($time)]);
                    }


                }




                //get id cat from id product
                $term_list = wp_get_post_terms($id,'product_cat',array('fields'=>'ids'));
                $last_item="";
                foreach($term_list as $list)
                {
                    $last_item =$list;
                }

                $cat_id = (int)$list;


                $c_update=	get_term_meta($cat_id,'_count_update',true);
                //	var_dump($c_update);

                $c_update_date=$c_update['date'];
                $c_update_product=$c_update['product'];





                $count_update_update =	get_gmt_from_date($time);
                $count_update_update = explode(' ', $count_update_update);



                if($count_update_update[0] != $c_update_date || $c_update_product != $id )
                {
                    /* var_dump($c_update_date);
           var_dump($count_update_update[0]);
           var_dump($c_update_product);
           var_dump($id);*/
                    add_term_meta($cat_id, '_count_update',['date' => $count_update_update[0],'product' => $id ]);

                }else
                {

                }






                //  update_post_meta($id, '_regular_price', $updated_price);
            }

            if ($key == 'call-' . $id) {
                if (isset($items)) {
                    update_post_meta($id, '_price', 'تماس بگیرید');
                    $time = current_time('mysql');

                    wp_update_post(
                        array(
                            'ID' => $id,
                            'post_date' => $time,
                            'post_date_gmt' => get_gmt_from_date($time)
                        )
                    );
                    // update_post_meta($id, '_sale_price', 'تماس بگیرید');
                }

            }
            if ($key == 'fix-' . $id) {
                if (isset($items)) {

                    $time = current_time('mysql');

                    wp_update_post(
                        array(
                            'ID' => $id,
                            'post_date' => $time,
                            'post_date_gmt' => get_gmt_from_date($time)
                        )
                    );
                    // update_post_meta($id, '_sale_price', 'تماس بگیرید');
                }

            }


        }
    }


//    $id=$_POST['id_product'];
//    $min = $_POST['mines'.$id];
//    $price = get_post_meta($_POST['id_product'], '_price', true);
//    $updated_price = $price - $min;
//    update_post_meta($_POST['id_product'], '_price', $updated_price);
//    update_post_meta($_POST['id_product'], '_sale_price', $updated_price);
//
//    $plus = $_POST['plus'];
//    $price = get_post_meta($_POST['id_product'], '_price', true);
//    $updated_price = $price + $plus;
//    update_post_meta($_POST['id_product'], '_price', $updated_price);
//    update_post_meta($_POST['id_product'], '_sale_price', $updated_price);
}


$taxonomy = 'product_cat';
$orderby = 'name';
$show_count = 0;      // 1 for yes, 0 for no
$pad_counts = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title = '';
$empty = 0;

$args = array(
    'taxonomy' => $taxonomy,
    'orderby' => $orderby,
    'show_count' => $show_count,
    'pad_counts' => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li' => $title,
    'hide_empty' => $empty
);
$sub_cate = [];
$all_categories = get_categories($args);
echo '
 <div class="form-group">
<select class="form-control" id="cate_product" name="cate_product">
<option value="-1">دسته بندی را انتخاب کنید</option>';
foreach ($all_categories as $cat) {
    if ($cat->category_parent == 0) {
        $category_id = $cat->term_id;
        echo '<option value="' . $category_id . '">' . $cat->name . '</option>';
        // echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';


    }
}
echo '</select>
</div>
 <div class="form-group">';
?>

<?php
echo '
 <div class="form-group">
<select class="form-control" id="sub_cate_product" name="sub_cate_product">
</select></div>';
?>
<label for="name_product"> نام محصول</label>
<input type="text" id="name_product" name="name_product">
<?php
$args =array(
    'posts_per_page' => -1,
    'post_type' => 'product',
    'orderby'   => 'meta_value_num',
    'meta_key'  => '_product_attributes',
    'order' => 'asc',

);


$all_product = new WP_Query($args);
$array_table=[];
$array_table_all=[];
if ($all_product->have_posts()):
    while ($all_product->have_posts()):$all_product->the_post();
        $array_table=[];
        $array_table[]= get_the_ID();
        $array_table[] =get_the_title();
        $array_table[] = get_post_meta(get_the_ID(), '_price', true);
        global $product;
        $array_table[] =  array_shift(wc_get_product_terms($product->id, 'pa_zekhamat', array('fields' => 'names')));

        $array_table_all []= $array_table;

    endwhile;
    $price = array();
    foreach ($array_table_all as $key => $row)
    {
        $price[$key] = $row[3];
    }
    array_multisort($price, SORT_DESC, $array_table_all);
    //  asort($array_table_all);

endif; ?>
<div id="show_data">
    <form action="" method="post">
        <select name="grouped" id="">
            <option value="angle" <?php if(get_option( '_key_group' )=='angle') echo "selected"?>>زاویه</option>
            <option value="brand" <?php if(get_option( '_key_group' )=='brand') echo "selected"?>>برند</option>
            <option value="color" <?php if(get_option( '_key_group' )=='color') echo "selected"?>>رنگ</option>
            <option value="material" <?php if(get_option( '_key_group' )=='material') echo "selected"?>>جنس</option>
            <option value="pressure" <?php if(get_option( '_key_group' )=='pressure') echo "selected"?>>فشار</option>
            <option value="rade" <?php if(get_option( '_key_group' )=='rade') echo "selected"?>>رده</option>
            <option value="size" <?php if(get_option( '_key_group' )=='size') echo "selected"?>>سایز</option>
            <option value="standard" <?php if(get_option( '_key_group' )=='standard') echo "selected"?>>استاندارد</option>
            <option value="state" <?php if(get_option( '_key_group' )=='state') echo "selected"?>>حالت طول شاخه</option>
            <option value="steel-color" <?php if(get_option( '_key_group' )=='steel-color') echo "selected"?>>رنگ استیل</option>
            <option value="tahvil" <?php if(get_option( '_key_group' )=='tahvil') echo "selected"?>>تحویل</option>
            <option value="vahed" <?php if(get_option( '_key_group' )=='vahed') echo "selected"?>>واحد</option>
            <option value="vazn" <?php if(get_option( '_key_group' )=='vazn') echo "selected"?>>وزن</option>
            <option value="zekhamat" <?php if(get_option( '_key_group' )=='zekhamat') echo "selected"?>>ضخامت</option>
            <option value="ویژگی-های-برتر" <?php if(get_option( '_key_group' )=='ویژگی-های-برتر') echo "selected"?>>ویژگی های برتر</option>

        </select>
        <input type="submit" name="save_key_group">
    </form>
    <form action="" method="post">

        <table class="table table-striped">
            <tr>
                <th scope="col">
                    شماره محصول
                </th>
                <th scope="col">
                    عنوان محصول
                </th>
                <th scope="col">
                    قیمت محصول
                </th>
                <th scope="col">
                    ضخامت
                </th>
                <th scope="col">
                    افزایش قیمت معمولی
                </th>
                <th scope="col">
                    کاهش قیمت معمولی
                </th>
                <th scope="col">
                    تغییر قیمت
                </th>
                <th>
                    تماس بگیرید
                </th>
                <th>
                    قیمت ثابت
                </th>

            </tr>
            <?php foreach ($array_table_all as $item):?>
                <tr>
                    <td>
                        <input class="form-control" type="text" readonly
                               name="id_product-<?php echo $item[0]; ?>" value="<?php echo $item[0] ?>">
                    </td>
                    <td>
                        <?php  echo $item[1];  ?>
                    </td>
                    <td>
                        <?php  echo $item[2]; ?>
                    </td>
                    <td>
                        <?php  echo $item[3]; ?>
                    </td>
                    <td>

                        <input class="form-control" type="text" name="plus_r-<?php echo $item[0]; ?>"
                               id="plus-<?php echo $item[0]; ?>" value="0">
                    </td>
                    <td>

                        <input class="form-control" type="text" name="mines_r-<?php  echo $item[0]; ?>"
                               id="mines-<?php echo $item[0]; ?>" value="0">
                    </td>
                    <td>

                        <input class="form-control" type="text" name="price-<?php  echo $item[0]; ?>"
                               id="price-<?php echo $item[0]; ?>" value="<?php echo $item[2]; ?>">
                    </td>
                    <td>
                        <input class="form-control" type="checkbox" name="call-<?php  echo $item[0]; ?>"
                               id="call-<?php  echo $item[0]; ?>">
                    </td>
                    <td>
                        <input class="form-control" type="checkbox" name="fix-<?php echo $item[0]; ?>"
                               id="fix-<?php echo $item[0];  ?>">
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
        <input class="btn btn-primary" type="submit" name="submit_price" value="اعمال تغییرات">
    </form>
</div>






