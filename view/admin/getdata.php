<?php
require_once('../../../../../wp-config.php');
$array_table = [];
$array_table_all = [];
if (isset($_POST['cat_id'])):
    $cat_id = $_POST['cat_id'];
    if ($cat_id != -1) {

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => -1,

            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms' => $cat_id,
                    'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'slug',
                    'terms' => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator' => 'NOT IN'
                )
            )
        );
        $all_product = new WP_Query($args);

        if ($all_product->have_posts()):
            while ($all_product->have_posts()):$all_product->the_post();
                $array_table = [];
                $array_table[] = get_the_ID();
                $array_table[] = get_the_title();
                $array_table[] = get_post_meta(get_the_ID(), '_price', true);
                global $product;
                $array_table[] = array_shift(wc_get_product_terms($product->id, 'pa_zekhamat', array('fields' => 'names')));

                $array_table_all [] = $array_table;

            endwhile;
            $price = array();
            foreach ($array_table_all as $key => $row) {
                $price[$key] = $row[3];
            }
            array_multisort($price, SORT_DESC, $array_table_all);

            ?>
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
                    <tbody>
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

                    <?php foreach ($array_table_all as $item): ?>
                        <tr>
                            <td>
                                <input class="form-control" type="text" readonly
                                       name="id_product-<?php echo $item[0]; ?>" value="<?php echo $item[0] ?>">
                            </td>
                            <td>
                                <?php echo $item[1]; ?>
                            </td>
                            <td>
                                <?php echo $item[2]; ?>
                            </td>
                            <td>
                                <?php echo $item[3]; ?>
                            </td>
                            <td>

                                <input class="form-control" type="text" name="plus_r-<?php echo $item[0]; ?>"
                                       id="plus-<?php echo $item[0]; ?>" value="0">
                            </td>
                            <td>

                                <input class="form-control" type="text" name="mines_r-<?php echo $item[0]; ?>"
                                       id="mines-<?php echo $item[0]; ?>" value="0">
                            </td>
                            <td>

                                <input class="form-control" type="text" name="price-<?php  echo $item[0]; ?>"
                                       id="price-<?php echo $item[0]; ?>" value="<?php echo $item[2]; ?>">
                            </td>

                            <td>
                                <input class="form-control" type="checkbox" name="call-<?php echo $item[0]; ?>"
                                       id="call-<?php echo $item[0]; ?>">
                            </td>
                            <td>
                                <input class="form-control" type="checkbox" name="fix-<?php echo $item[0]; ?>"
                                       id="fix-<?php echo $item[0]; ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <input type="submit" name="submit_price" value="اعمال تغییرات">
            </form>
        <?php
        endif;
    } else {
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
        endif;
        ?>
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

                <?php foreach ($array_table_all as $item): ?>
                    <tr>
                        <td>
                            <input class="form-control" type="text" readonly
                                   name="id_product-<?php echo $item[0]; ?>" value="<?php echo $item[0] ?>">
                        </td>
                        <td>
                            <?php echo $item[1]; ?>
                        </td>
                        <td>
                            <?php echo $item[2]; ?>
                        </td>
                        <td>
                            <?php echo $item[3]; ?>
                        </td>
                        <td>

                            <input class="form-control" type="text" name="plus_r-<?php echo $item[0]; ?>"
                                   id="plus-<?php echo $item[0]; ?>" value="0">
                        </td>
                        <td>

                            <input class="form-control" type="text" name="mines_r-<?php echo $item[0]; ?>"
                                   id="mines-<?php echo $item[0]; ?>" value="0">
                        </td>

                        <td>

                            <input class="form-control" type="text" name="price-<?php  echo $item[0]; ?>"
                                   id="price-<?php echo $item[0]; ?>" value="<?php echo $item[2]; ?>">
                        </td>

                        <td>
                            <input class="form-control" type="checkbox" name="call-<?php echo $item[0]; ?>"
                                   id="call-<?php echo $item[0]; ?>">
                        </td>
                        <td>
                            <input class="form-control" type="checkbox" name="fix-<?php echo $item[0]; ?>"
                                   id="fix-<?php echo $item[0]; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input type="submit" name="submit_price" value="اعمال تغییرات">
        </form>
        <?php
    }
endif;
?>
<?php
if (isset($_POST['name_product'])):
    $name_product = $_POST['name_product'];
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        's' => $_POST['name_product']
    );
    $the_query = new WP_Query($args);
    ?>
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
    <tbody>
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

    <?php
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):
            $the_query->the_post();
            $id = get_the_ID();
            ?>

            <tr>
                <td>
                    <input class="form-control" type="text" readonly name="id_product-<?php echo get_the_ID(); ?>"
                           value="<?php the_ID(); ?>">
                </td>
                <td>
                    <?php echo get_the_title() ?>
                </td>
                <td>
                    <?php echo get_post_meta(get_the_ID(), '_price', true); ?>
                </td>
                <td>
                    <?php global $product;
                    $koostis = array_shift(wc_get_product_terms($product->id, 'pa_zekhamat', array('fields' => 'names')));
                    echo $koostis; ?>
                </td>
                <td>

                    <input class="form-control" type="text" name="plus_r-<?php echo get_the_ID(); ?>"
                           id="plus_r-<?php echo get_the_ID(); ?>" value="0">
                </td>
                <td>

                    <input class="form-control" type="text" name="mines_r-<?php echo get_the_ID(); ?>"
                           id="mines_r-<?php echo get_the_ID(); ?>" value="0">
                </td>
                <td>

                    <input class="form-control" type="text" name="price-<?php echo  get_the_ID(); ?>"
                           id="price-<?php echo get_the_ID(); ?>" value="<?php echo get_post_meta(get_the_ID(), '_price', true); ?>">
                </td>
                <td>

                    <input class="form-control" type="checkbox" name="call-<?php echo get_the_ID(); ?>"
                           id="call-<?php echo get_the_ID(); ?>">
                </td>
                <td>
                    <input class="form-control" type="checkbox" name="fix-<?php echo get_the_ID(); ?>"
                           id="fix-<?php echo get_the_ID(); ?>">
                </td>


            </tr>

        <?php
        endwhile;
        ?>
        </tbody>
        </table>
        <input type="submit" name="submit_price" value="اعمال تغییرات">
        </form>
    <?php endif;
endif; ?>

<?php
if (isset($_POST['cat_id_f_sub'])) {
    $taxonomy = 'product_cat';
    $orderby = 'name';
    $show_count = 0;      // 1 for yes, 0 for no
    $pad_counts = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title = '';
    $empty = 0;

    $args2 = array(
        'taxonomy' => $taxonomy,
        'child_of' => 0,
        'parent' => $_POST['cat_id_f_sub'],
        'orderby' => $orderby,
        'show_count' => $show_count,
        'pad_counts' => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li' => $title,
        'hide_empty' => $empty
    );

    $sub_cats = get_categories($args2);

    $sub_cate = [];
    foreach ($sub_cats as $sub_category) {

        array_push($sub_cate, $sub_category);
    }
    //   var_dump($sub_cate);

    echo '<option value="-1">دسته بندی فرعی را انتخاب کنید</option>';
    foreach ($sub_cate as $cat) {
        echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';

    }
}
?>
<?php




