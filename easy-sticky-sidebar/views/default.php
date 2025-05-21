<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly 
}
if ( $ctacontent->SSuprydp_button_option_color) {
	$button_color = sanitize_hex_color($ctacontent->SSuprydp_button_option_color);
}

if ( $ctacontent->SSuprydp_button_option_backg_color) {
	$button_background_color = sanitize_hex_color($ctacontent->SSuprydp_button_option_backg_color);
}

if ( $ctacontent->SSuprydp_content_option_color) {
	$content_color = sanitize_hex_color($ctacontent->SSuprydp_content_option_color);
}

if ( $ctacontent->content_background_color) {
	$contents_background_color = sanitize_hex_color($ctacontent->content_background_color);
}

if ( $ctacontent->SSuprydp_action_option_color) {
	$link_color = sanitize_hex_color($ctacontent->SSuprydp_action_option_color);
}

if ( $ctacontent->link_text_background) {
	$links_text_background = sanitize_hex_color($ctacontent->link_text_background);
}

if ('yes' == $ctacontent->collapse_on_page_load) {
	array_push($cta_classes, 'shrink');
}

$cta_links_attrs = '';
$tag = 'div';
if ($ctacontent->SSuprydp_action_option_url) {
	$tag = 'a';
	$cta_links_attrs = sprintf('href="%s"', esc_url_raw($ctacontent->SSuprydp_action_option_url));
}

if ($ctacontent->SSuprydp_target_blank == 'Yes') {
	$cta_links_attrs .= ' target="_blank"';
}

if ($ctacontent->SSuprydp_nofollow == 'Yes') {
	$cta_links_attrs .= ' rel="nofollow"';
}

ob_start(); ?>

<div id="<?php echo esc_attr('easy-sticky-sidebar-' . $ctacontent->id); ?>"
    class="<?php echo esc_attr(implode(' ', $cta_classes)); ?>" data-id="<?php echo esc_attr($ctacontent->id); ?>">

    <div class="sticky-sidebar-button" style="background-color:<?php echo esc_attr($button_background_color); ?>">
        <div style="color: <?php echo esc_attr($button_color); ?>;">
            <?php do_action('easy_sticky_sidebar_sticky_cta_button', $ctacontent); ?>
        </div>
        <?php
		if (function_exists('wordpress_cta_pro_get_close_button')) {
			wordpress_cta_pro_get_close_button($ctacontent);
		}
		?>
    </div>

    <<?php echo esc_html($tag); ?> class="sticky-sidebar-content sticky-sidebar-container"
        <?php echo $cta_links_attrs; ?>>
        <?php


// print_r($ctacontent);
		$image = $ctacontent->sticky_s_media;

	 if ('yes' != $ctacontent->hide_cta_image) { ?>
        <div class="sticky-sidebar-image" style="background-image: url('<?php echo $image; ?>');"></div>
        <?php } ?>

        <div class="sticky-sidebar-text sticky-content-inner"
            style="color: <?php echo esc_attr($content_color); ?>; background-color: <?php echo esc_attr($contents_background_color); ?>;">
            <?php echo do_shortcode(wp_kses_post($ctacontent->SSuprydp_content_option_text)); ?>
        </div>

        <?php if (!empty($ctacontent->SSuprydp_action_option_url)) :
			if ($ctacontent->line_separator_show !== 'no') {
				echo '<hr>';
			}

			if ($ctacontent->hide_call_to_action !== 'yes') {
				$style = sprintf(
					'color:%s; background-color:%s;',
					esc_attr($link_color),
					esc_attr($links_text_background)
				);

				printf(
					'<div class="sticky-sidebar-call-to-action sticky-content-inner" style="%s">%s</div>',
					$style,
					wp_kses_post($ctacontent->SSuprydp_action_option_text)
				);
			}
		endif; ?>
    </<?php echo esc_html($tag); ?>>
</div>
<?php

echo ob_get_clean();