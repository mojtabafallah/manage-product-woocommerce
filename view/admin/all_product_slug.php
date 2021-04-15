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
include 'Layout/main_layout_slug.php';

if (isset($_POST['submit_slug'])) {

    foreach ($_POST as $key => $items) {
        $pos = strpos($key, '-');
        $id = substr($key, $pos + 1);

        if (intval($id)) {

            if ($key == 'plus_r-' . $id) {
                $plus = $items;
            
                wp_update_post(
                    array (
                        'ID'        => $id,
                        'post_name' => $plus
                    )
                );
            }


        }
    }

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


<div id="show_data">
    <form action="" method="post">
        <table class="table table-striped">
            <tr>
			<th>
			 ردیف
			</th>
                <th scope="col">
                    شماره محصول
                </th>
                <th scope="col">
                    عنوان محصول
                </th>
                <th scope="col">
                    نامک محصول
                </th>

            </tr>

            <?php 
			//$myarray = range(0, 12);
			$all_product = new WP_Query(array(
                'post_type' => 'product',
				'order_by' => 'id',
                'posts_per_page' => -1,
			 //'post__in'      => $myarray
            ));
            if ($all_product->have_posts()):
			$cc=1;
                while ($all_product->have_posts()):$all_product->the_post(); ?>
                    <tr>
					<td>
					   <?php echo $cc;
					   $cc++;?>

					</td>
                        <td>
                            <input class="form-control" type="text" readonly
                                   name="id_product-<?php echo get_the_ID(); ?>" value="<?php the_ID(); ?>">
                        </td>
                        <td>
                            <?php echo get_the_title() ?>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="plus_r-<?php echo get_the_ID(); ?>"
                                   id="plus-<?php echo get_the_ID(); ?>" value="<?php
                            $post_id = get_the_ID();
                            $post = get_post($post_id);
                            $slug = $post->post_name;
                            echo $slug;
                            ?>">

                        </td>

                    </tr>
                <?php
                endwhile;
            endif; ?>
        </table>
        <input class="btn btn-primary" type="submit" name="submit_slug" value="اعمال تغییرات">
    </form>
</div>






