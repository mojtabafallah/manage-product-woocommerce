<div class="wrap">
    <h1>گروه بندی دسته بندی ها</h1>

    <?php
    /* save term meta */
    if (isset($_POST['apply'])) {

        update_term_meta($_POST['id'], '_grouped', $_POST['grouped']);
        update_term_meta($_POST['id'], '_sorted', $_POST['sorted']);

    }

    /* end save term meta */


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
';
    foreach ($all_categories as $cat) {
        $category_id = $cat->term_id;
        echo "
<form action='' method='post'>
<input type='text' readonly name='id' value='$category_id' >";
        echo "<input type='text' disabled value='$cat->name' >";
        $g=get_term_meta($category_id, '_grouped', true);
        $s=get_term_meta($category_id, '_sorted', true);
        display_attributes($g);

        display_attributes_sort($s);


        echo '</form>';
        echo get_term_meta($category_id, '_grouped', true);
    }
    echo '
</div>';


    function display_attributes($category_id)
    {
      ?>
<label for='grouped'>
گروه بندی
    <select name='grouped' id='grouped'>
    <option value='angle' <?php if ($category_id=='angle') echo 'selected'?>>زاویه</option>
    <option value='brand' <?php if ($category_id=='brand') echo 'selected'?>>برند</option>
    <option value='color' <?php if ($category_id=='color') echo 'selected'?>>رنگ</option>
    <option value='material' <?php if ($category_id=='material') echo 'selected'?>>جنس</option>
    <option value='pressure' <?php if ($category_id=='pressure') echo 'selected'?>>فشار</option>
    <option value='rade' <?php if ($category_id=='rade') echo 'selected'?>>رده</option>
    <option value='size' <?php if ($category_id=='size') echo 'selected'?>>سایز</option>
    <option value='standard' <?php if ($category_id=='standard') echo 'selected'?>>استاندارد</option>
    <option value='state' <?php if ($category_id=='state') echo 'selected'?>>حالت طول شاخه</option>
    <option value='steel-color' <?php if ($category_id=='steel-color') echo 'selected'?>>رنگ استیل</option>
    <option value='tahvil' <?php if ($category_id=='tahvil') echo 'selected'?>>تحویل</option>
    <option value='vahed' <?php if ($category_id=='vahed') echo 'selected'?>>واحد</option>
    <option value='vazn' <?php if ($category_id=='vazn') echo 'selected'?>>وزن</option>
    <option value='zekhamat' <?php if ($category_id=='zekhamat') echo 'selected'?>>ضخامت</option>
    <option value='ویژگی-های-برتر' <?php if ($category_id=='ویژگی-های-برتر' ) echo 'selected'?>>ویژگی های برتر</option>

</select>
</label>
<?php
    }

    function display_attributes_sort($category_id)
    {
        ?>
        <label for='sorted'>
          مرتب سازی
            <select name='sorted' id='sorted'>
                <option value='angle' <?php if ($category_id=='angle') echo 'selected'?>>زاویه</option>
                <option value='brand' <?php if ($category_id=='brand') echo 'selected'?>>برند</option>
                <option value='color' <?php if ($category_id=='color') echo 'selected'?>>رنگ</option>
                <option value='material' <?php if ($category_id=='material') echo 'selected'?>>جنس</option>
                <option value='pressure' <?php if ($category_id=='pressure') echo 'selected'?>>فشار</option>
                <option value='rade' <?php if ($category_id=='rade') echo 'selected'?>>رده</option>
                <option value='size' <?php if ($category_id=='size') echo 'selected'?>>سایز</option>
                <option value='standard' <?php if ($category_id=='standard') echo 'selected'?>>استاندارد</option>
                <option value='state' <?php if ($category_id=='state') echo 'selected'?>>حالت طول شاخه</option>
                <option value='steel-color' <?php if ($category_id=='steel-color') echo 'selected'?>>رنگ استیل</option>
                <option value='tahvil' <?php if ($category_id=='tahvil') echo 'selected'?>>تحویل</option>
                <option value='vahed' <?php if ($category_id=='vahed') echo 'selected'?>>واحد</option>
                <option value='vazn' <?php if ($category_id=='vazn') echo 'selected'?>>وزن</option>
                <option value='zekhamat' <?php if ($category_id=='zekhamat') echo 'selected'?>>ضخامت</option>
                <option value='ویژگی-های-برتر' <?php if ($category_id=='ویژگی-های-برتر' ) echo 'selected'?>>ویژگی های برتر</option>

            </select>
        </label>
        <input type="submit" name="apply" value="اعمال">
        <?php

    }

    ?>


</div>
