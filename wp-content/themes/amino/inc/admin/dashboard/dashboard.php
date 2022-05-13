<?php
/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
require_once dirname( __FILE__ ) . '/admin-options.php';
require_once dirname( __FILE__ ) . '/product.php';
/*
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 *
 * You can delete it if you not using that option
 */
add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#example_showhidden').click(function() {
        jQuery('#section-example_text_hidden').fadeToggle(400);
    });
    if (jQuery('#example_showhidden:checked').val() !== undefined) {
        jQuery('#section-example_text_hidden').show();
    }
    jQuery('#active_catalog').click(function() {
        jQuery('#section-price_disabled').fadeToggle(400);
    });
    if (jQuery('#active_catalog:checked').val() !== undefined) {
        jQuery('#section-price_disabled').show();
    }
});
</script>
<?php
}
