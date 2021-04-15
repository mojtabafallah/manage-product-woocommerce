jQuery(document).ready(function () {

    jQuery('#cate_product').change(function () {
        var cate_id=jQuery('#cate_product').val();
jQuery.ajax({
            type: 'post',
            url: '../wp-content/plugins/manage-wc/view/admin/getdata.php',
            data: {cat_id_f_sub: cate_id},
            success: function (response, error) {
                if (response !== '') {
					console.log(response);
                    jQuery('#sub_cate_product')
                        .empty()
                        .append(response);
						
                }
				console.log(error);
            }
        });
        jQuery.ajax({
            type: 'post',
            url: '../wp-content/plugins/manage-wc/view/admin/getdata.php',
            data: {cat_id: cate_id},
            success: function (response, error) {

                if (response !== '') {
                    jQuery('#show_data')
                        .empty()
                        .append(response);

                }
				console.log(error);
            }
        });
		
    });
    jQuery('#sub_cate_product').change(function () {
        var cate_id=jQuery('#sub_cate_product').val();

        jQuery.ajax({
            type: 'post',
            url: '../wp-content/plugins/manage-wc/view/admin/getdata.php',
            data: {cat_id: cate_id},
            success: function (response, error) {

                if (response !== '') {
                    jQuery('#show_data')
                        .empty()
                        .append(response);

                }
            }
        });
    });
    jQuery('#name_product').keyup(function () {
        var name=jQuery('#name_product').val();

        jQuery.ajax({
            type: 'post',
            url: '../wp-content/plugins/manage-wc/view/admin/getdata.php',
            data: {name_product: name},
            success: function (response, error) {

                if (response !== '') {
                    jQuery('#show_data')
                        .empty()
                        .append(response);

                }
            }
        });
    });

});