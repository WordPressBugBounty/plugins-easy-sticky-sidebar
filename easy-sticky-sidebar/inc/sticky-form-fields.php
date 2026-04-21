<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly 
}

function easy_sticky_sidebar_cta_position($stickycta, $sticky_id) {
	$positions = array(
		'right' => __('Right', 'easy-sticky-sidebar'),
		'left' => __('Left', 'easy-sticky-sidebar'),
		'top' => __('Top', 'easy-sticky-sidebar'),
		'bottom' => __('Bottom', 'easy-sticky-sidebar'),
	);

	$pro_features = ['left', 'top', 'bottom'];

	$cta_position = $stickycta->SSuprydp_cta_position;
	if ($cta_position == '' || !easy_sticky_sidebar_has_pro()) {
		$cta_position = 'right';
	} 
	
	$h_positions = function_exists('easy_sticky_sidebar_get_secondary_position_options')
		? easy_sticky_sidebar_get_secondary_position_options($cta_position)
		: array(
			'top'    => __('Top', 'easy-sticky-sidebar'),
			'center' => __('Center', 'easy-sticky-sidebar'),
			'bottom' => __('Bottom', 'easy-sticky-sidebar'),
		);
	$pro_h_features = function_exists('easy_sticky_sidebar_is_vertical_cta_position') && easy_sticky_sidebar_is_vertical_cta_position($cta_position)
		? ['left', 'right']
		: ['top', 'bottom'];
	$position_label = function_exists('easy_sticky_sidebar_is_vertical_cta_position') && easy_sticky_sidebar_is_vertical_cta_position($cta_position)
		? __('Horizontal Position', 'easy-sticky-sidebar')
		: __('Vertical Position', 'easy-sticky-sidebar');

	$cta_h_position = function_exists('easy_sticky_sidebar_normalize_secondary_position')
		? easy_sticky_sidebar_normalize_secondary_position($cta_position, $stickycta->horizontal_vertical_position ?? '', 'center')
		: ($stickycta->horizontal_vertical_position ?: 'center');
	if (!easy_sticky_sidebar_has_pro()) {
		$cta_h_position = 'center';
	}
	
	?>

	<div id="easy-sticky-sidebar-position">
		<?php do_action('easy_sticky_sidebar/cta_position_fields', $stickycta); ?>

		<div class="SSuprydp_field_wrap">
			<label><?php esc_html_e("Position", "easy-sticky-sidebar"); ?></label>

			<div class="group-inline-field group-inline-field-position">
				<select class="input-field" name="SSuprydp_cta_position" data-position="<?php echo esc_attr($cta_position) ?>">
					<?php
					foreach ($positions as $key => $position) {
						$disabled = in_array($key, $pro_features, true) && !easy_sticky_sidebar_has_pro();
						if ($disabled) {
							$position = sprintf('%s (%s)', $position, __('Pro Feature', 'easy-sticky-sidebar'));
						}

						printf(
							'<option value="%s"%s%s>%s</option>',
							esc_attr($key),
							selected($key, $cta_position, false),
							$disabled ? ' disabled="disabled"' : '',
							esc_html($position)
						);
					}
					?>
				</select>
			</div>
		</div>

		<div id="cta-horizontal-vertical-position" class="SSuprydp_field_wrap" data-position="<?php echo esc_attr($cta_h_position) ?>">
			<div class="group-inline-field group-inline-field-position">
			<div class="horizontal_vertical_position-wrapper">
					<label><?php echo esc_html($position_label); ?></label>
					<select class="input-field" name="horizontal_vertical_position" data-position="<?php echo esc_attr($cta_h_position) ?>">
					<?php
					foreach ($h_positions as $key => $position) {
						$disabled = in_array($key, $pro_h_features, true) && !easy_sticky_sidebar_has_pro();
						if ($disabled) {
							$position = sprintf('%s (%s)', $position, __('Pro Feature', 'easy-sticky-sidebar'));
						}

						printf(
							'<option value="%s"%s%s>%s</option>',
							esc_attr($key),
							selected($key, $cta_h_position, false),
							$disabled ? ' disabled="disabled"' : '',
							esc_html($position)
						);
					}
					?>


					</select>
					<input type="hidden" name="horizontal_vertical_position_value" value="<?php echo esc_attr($cta_h_position); ?>">
				</div>
				<?php do_action('easy_sticky_sidebar_after_position2', $stickycta) ?>
			</div>
		</div>
	</div>
<?php
}
add_action('easy_sticky_sidebar_cta_position', 'easy_sticky_sidebar_cta_position', 10, 2);

add_action('easy_sticky_sidebar_form_cta_location', 'easy_sticky_sidebar_form_page_location', 10, 2);
function easy_sticky_sidebar_form_page_location($stickycta, $sticky_id) {
	$front_page = get_option('page_on_front'); ?>
	<h4 class="wordpress-cta-heading"><?php esc_html_e("Page / Post Location", "easy-sticky-sidebar"); ?></h4>
	<p class="wordpress-cta-instruction"><?php esc_html_e('Select where to display your CTA. Choose between the entire site or the home page.', 'easy-sticky-sidebar') ?></p>

	<?php
	if (!easy_sticky_sidebar_has_pro()) {
		echo '<p class="wordpress-cta-instruction text-bold">Get more options with our <a href="https://wpctapro.com/" target="_blank">pro version</a>.</p>';
	}

	// echo '<div class="SSuprydp_field_wrap">';
	// if (!$front_page) {
	// 	echo '<div style="margin-top:5px"></div>';
		
	// } else {
	// 	echo '<label>' . esc_html__("Location", "easy-sticky-sidebar") . '</label>';
	// 	echo '<select name="SSuprydp_location" class="SSuprydp_location">';
	// 	printf('<option value="" %s>%s</option>', selected('', $stickycta->SSuprydp_location, false), esc_html__('Entire Site', 'easy-sticky-sidebar'));
	// 	printf('<option value="%d" %s>%s</option>', $front_page, selected($front_page, $stickycta->SSuprydp_location, false), esc_html(get_the_title($front_page)));
	// 	echo '</select>';
	// }
	// echo '</div>';
}

/**
 * CTA button font field
 * @since 1.3.6
 */
function easy_sticky_sidebar_button_font($stickycta) { ?>
	<div class="SSuprydp_field_wrap sticky-sidebar-button_font field-google-font">
		<label><?php esc_html_e("Font Family", "easy-sticky-sidebar"); ?></label>
		<input id="SSuprydp_button_option_font" name="SSuprydp_button_option_font" type="text" value="<?php echo esc_attr($stickycta->SSuprydp_button_option_font) ?>" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_button_options', 'easy_sticky_sidebar_button_font', 15);

/**
 * CTA button font size field
 * @since 1.3.6
 */
function easy_sticky_sidebar_button_font_size($stickycta) { ?>
	<div class="SSuprydp_field_wrap sticky-sidebar-button_fontsize">
		<label><?php esc_html_e("Font Size", "easy-sticky-sidebar"); ?></label>
		<?php $button_size = preg_replace('/[^0-9.]/', '', (string) $stickycta->SSuprydp_button_option_size); ?>
		<input style="width: 50px;text-align:right" type="number" min="0" name="SSuprydp_button_option_size" value="<?php echo esc_attr($button_size); ?>"> px
	</div>
<?php
}
add_action('easy_sticky_sidebar_button_options', 'easy_sticky_sidebar_button_font_size', 25);

/**
 * CTA button button color field
 * @since 1.3.6
 */
function easy_sticky_sidebar_button_color($stickycta) { ?>
	<div class="SSuprydp_field_wrap sticky-sidebar-button_text_color">
		<label><?php esc_html_e("Text Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="SSuprydp_button_option_color" value="<?php echo esc_attr($stickycta->SSuprydp_button_option_color); ?>" class="sticky-sidebar-colorpicker" />
	</div>

	<div class="SSuprydp_field_wrap button-text-hover-color">
		<label><?php esc_html_e("Button Text Hover", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="button1_text_hover" value="<?php echo esc_attr($stickycta->button1_text_hover); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_button_options', 'easy_sticky_sidebar_button_color', 35);


/**
 * CTA button button color field
 * @since 1.3.6
 */
function easy_sticky_sidebar_button_background($stickycta) { ?>
	<div class="SSuprydp_field_wrap sticky-sidebar-button_background_color">
		<label><?php esc_html_e("Background Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="SSuprydp_button_option_backg_color" value="<?php echo esc_attr($stickycta->SSuprydp_button_option_backg_color); ?>" class="sticky-sidebar-colorpicker" />
	</div>

	<div class="SSuprydp_field_wrap button-background-hover">
		<label><?php esc_html_e("Button Background Hover", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="button1_background_hover" value="<?php echo esc_attr($stickycta->button1_background_hover); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_button_options', 'easy_sticky_sidebar_button_background', 40);

/**
 * CTA content font
 * @since 1.4.0
 */
function easy_sticky_sidebar_content_show_hide($stickycta) { ?>
	<div class="SSuprydp_field_wrap">
		<div class="heading"><?php esc_html_e("Hide / Show Content", "easy-sticky-sidebar"); ?></div>
		<label class="SSuprydp_switch">
			<input type="hidden" name="hide_content_text" value="no">
			<input type="checkbox" name="hide_content_text" value="yes" <?php checked('yes', $stickycta->hide_content_text) ?> class="develop_check checkbox-hide-show">
		</label>
	</div>
<?php
}
add_action('easy_sticky_sidebar_content_option', 'easy_sticky_sidebar_content_show_hide', 1, 2);

/**
 * CTA content font
 * @since 1.4.0
 */
function easy_sticky_sidebar_content_font($stickycta) { ?>
	<div class="SSuprydp_field_wrap field-google-font">
		<label><?php esc_html_e("Font Family", "easy-sticky-sidebar"); ?></label>
		<input id="SSuprydp_content_option_font" name="SSuprydp_content_option_font" type="text" value="<?php echo esc_attr($stickycta->SSuprydp_content_option_font) ?>" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_content_option', 'easy_sticky_sidebar_content_font', 5, 2);

/**
 * CTA content font size
 * @since 1.4.0
 */
function easy_sticky_sidebar_content_font_size($stickycta) { ?>
	<div class="SSuprydp_field_wrap hide-on-html-template">
		<label><?php esc_html_e("Font Size", "easy-sticky-sidebar"); ?></label>
		<?php $content_size = preg_replace('/[^0-9.]/', '', (string) $stickycta->SSuprydp_content_option_size); ?>
		<input style="width: 50px;text-align:right" type="number" min="0" name="SSuprydp_content_option_size" value="<?php echo esc_attr($content_size); ?>"> px
	</div>
<?php
}
add_action('easy_sticky_sidebar_content_option', 'easy_sticky_sidebar_content_font_size', 10);


/**
 * CTA content text color
 * @since 1.4.0
 */
function easy_sticky_sidebar_content_text_color($stickycta) { ?>
	<div class="SSuprydp_field_wrap">
		<label><?php esc_html_e("Text Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="SSuprydp_content_option_color" value="<?php echo esc_attr($stickycta->SSuprydp_content_option_color); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_content_option', 'easy_sticky_sidebar_content_text_color', 15, 2);


function easy_sticky_sidebar_content_background_color($stickycta) {
	$wrapper_classes = array('SSuprydp_field_wrap', 'sticky-sidebar-content_background_color');
	if (($stickycta->sidebar_template ?? '') === 'sticky-cta') {
		$wrapper_classes[] = 'cta-image-classic-only';
	}
?>
	<div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
		<label><?php esc_html_e("Background Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="content_background_color" value="<?php echo esc_attr($stickycta->content_background_color); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_content_option', 'easy_sticky_sidebar_content_background_color', 20, 2);

add_action('easy_sticky_sidebar_line_separator', 'easy_sticky_sidebar_line_separator_show', 1, 2);
function easy_sticky_sidebar_line_separator_show($stickycta) {
?>
	<div class="SSuprydp_field_wrap">
		<div class="heading"><?php esc_html_e("Show/Hide Line Separator", "easy-sticky-sidebar"); ?></div>
		<label class="SSuprydp_switch">
			<input type="hidden" name="line_separator_show" value="no">
			<input type="checkbox" name="line_separator_show" value="yes" <?php checked('yes', $stickycta->line_separator_show) ?> class="develop_check checkbox-show-hide">
		</label>
	</div>
<?php
}

add_action('easy_sticky_sidebar_line_separator', 'easy_sticky_sidebar_line_separator_color', 10, 2);
function easy_sticky_sidebar_line_separator_color($stickycta, $sticky_id) {
?>
	<div class="SSuprydp_field_wrap">
		<label><?php esc_html_e("Line Separator Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="line_separator_color" value="<?php echo esc_attr($stickycta->line_separator_color); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}

/**
 * Add call to action text
 * @since 1.3.7
 */
function easy_sticky_sidebar_call_top_action_font($stickycta) { ?>
	<div class="SSuprydp_field_wrap call-to-action-font field-google-font">
		<label><?php esc_html_e("Font Family", "easy-sticky-sidebar"); ?></label>
		<input id="SSuprydp_action_option_font" name="SSuprydp_action_option_font" type="text" value="<?php echo esc_attr($stickycta->SSuprydp_action_option_font); ?>" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_call_to_action', 'easy_sticky_sidebar_call_top_action_font', 10);

/**
 * Add call to action font weight
 * @since 1.3.7
 */
function easy_sticky_sidebar_call_top_action_font_size($stickycta) { ?>
	<div class="SSuprydp_field_wrap call-to-action-font-size hide-on-html-template">
		<label><?php esc_html_e("Font Size", "easy-sticky-sidebar"); ?></label>
		<?php $action_size = preg_replace('/[^0-9.]/', '', (string) $stickycta->SSuprydp_action_option_size); ?>
		<input style="width: 50px;text-align:right" type="number" min="0" name="SSuprydp_action_option_size" value="<?php echo esc_attr($action_size); ?>"> px
	</div>
<?php
}
add_action('easy_sticky_sidebar_call_to_action', 'easy_sticky_sidebar_call_top_action_font_size', 15);

/**
 * Add call to action text color
 * @since 1.3.7
 */
function easy_sticky_sidebar_call_top_action_textcolor($stickycta) { ?>
	<div class="SSuprydp_field_wrap call-to-action-textcolor">
		<label><?php esc_html_e("Text Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="SSuprydp_action_option_color" value="<?php echo esc_attr($stickycta->SSuprydp_action_option_color); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_call_to_action', 'easy_sticky_sidebar_call_top_action_textcolor', 20);

/**
 * Add call to action text background color
 * @since 1.3.7
 */
function easy_sticky_sidebar_link_text_background($stickycta) { ?>
	<div class="SSuprydp_field_wrap call-to-action-background-color">
		<label><?php esc_html_e("Background Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="link_text_background" value="<?php echo esc_attr($stickycta->link_text_background); ?>" class="sticky-sidebar-colorpicker" />
	</div>
<?php
}
add_action('easy_sticky_sidebar_call_to_action', 'easy_sticky_sidebar_link_text_background', 25);

/**
 * Sticky classic button padding.
 * @since 2.4.0
 */
function easy_sticky_sidebar_call_to_action_padding_classic($stickycta) {
	$padding_values = $stickycta->call_to_action_padding ?? array();
	if (class_exists('Easy_Sticky_Sidebar_Utils')) {
		$normalized = Easy_Sticky_Sidebar_Utils::get_dimensions_values((array) $padding_values);
		if (!empty($normalized->empty)) {
			$padding_values = array(
				'top'    => '14',
				'right'  => '24',
				'bottom' => '14',
				'left'   => '24',
				'unit'   => 'px',
			);
		}
	}
	?>
	<div class="SSuprydp_field_wrap cta-image-classic-only">
		<label><?php esc_html_e('Padding', 'easy-sticky-sidebar'); ?></label>
		<?php Easy_Sticky_Sidebar_Utils::get_dimensions_field('call_to_action_padding', (array) $padding_values); ?>
	</div>
	<?php
}
add_action('easy_sticky_sidebar_call_to_action', 'easy_sticky_sidebar_call_to_action_padding_classic', 27);

/**
 * Overlay-mode button spacing and radius (shown inside CTA Button Options).
 * @since 2.3.0
 */
function easy_sticky_sidebar_overlay_button_option_fields($stickycta) { ?>
	<?php
	$overlay_padding_values = $stickycta->overlay_button_padding ?? array();
	if (!is_array($overlay_padding_values) || empty($overlay_padding_values)) {
		$pad_v = max(0, absint($stickycta->overlay_button_padding_v ?? 5));
		$pad_h = max(0, absint($stickycta->overlay_button_padding_h ?? 20));
		$overlay_padding_values = array(
			'top'    => $pad_v,
			'right'  => $pad_h,
			'bottom' => $pad_v,
			'left'   => $pad_h,
			'unit'   => 'px',
		);
	}
	?>
	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Button Padding", "easy-sticky-sidebar"); ?></label>
		<?php Easy_Sticky_Sidebar_Utils::get_dimensions_field('overlay_button_padding', (array) $overlay_padding_values); ?>
	</div>

	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Button Radius", "easy-sticky-sidebar"); ?></label>
		<input style="width: 60px;text-align:right" type="number" min="0" name="overlay_button_radius" value="<?php echo esc_attr(absint($stickycta->overlay_button_radius ?? 50)); ?>"> px
	</div>
<?php
}
add_action('easy_sticky_sidebar_call_to_action', 'easy_sticky_sidebar_overlay_button_option_fields', 30);

/**
 * Sticky CTA image display defaults.
 * @since 2.3.0
 */
function easy_sticky_sidebar_image_mode_defaults($defaults) {
	$defaults['image_placement'] = $defaults['image_placement'] ?? 'classic';
	$defaults['hide_cta_image'] = $defaults['hide_cta_image'] ?? 'no';
	$defaults['cta_image_height'] = $defaults['cta_image_height'] ?? 300;
	$defaults['overlay_position'] = $defaults['overlay_position'] ?? 'right';
	$defaults['overlay_content_alignment'] = $defaults['overlay_content_alignment'] ?? '';
	$defaults['overlay_button_alignment'] = $defaults['overlay_button_alignment'] ?? '';
	$defaults['overlay_backdrop_color'] = $defaults['overlay_backdrop_color'] ?? '#ffffff';
	$defaults['overlay_backdrop_opacity'] = $defaults['overlay_backdrop_opacity'] ?? 70;
	$defaults['overlay_width'] = $defaults['overlay_width'] ?? 60;
	$defaults['overlay_content_padding'] = $defaults['overlay_content_padding'] ?? 12;
	$defaults['overlay_button_padding_v'] = $defaults['overlay_button_padding_v'] ?? 5;
	$defaults['overlay_button_padding_h'] = $defaults['overlay_button_padding_h'] ?? 20;
	$defaults['overlay_button_padding'] = $defaults['overlay_button_padding'] ?? array(
		'top'    => $defaults['overlay_button_padding_v'],
		'right'  => $defaults['overlay_button_padding_h'],
		'bottom' => $defaults['overlay_button_padding_v'],
		'left'   => $defaults['overlay_button_padding_h'],
		'unit'   => 'px',
	);
	$defaults['overlay_button_radius'] = $defaults['overlay_button_radius'] ?? 50;
	$defaults['overlay_content_gap'] = $defaults['overlay_content_gap'] ?? 10;

	// Sticky classic defaults (do not apply to overlay mode).
	$template = (string) ($defaults['sidebar_template'] ?? 'sticky-cta');
	$mode = strtolower((string) ($defaults['image_placement'] ?? 'classic'));
	if ($mode === 'background') {
		$mode = 'overlay';
	}
	if ($template === 'sticky-cta' && $mode === 'overlay') {
		$defaults['SSuprydp_content_option_font'] = 'Arial';
		$defaults['SSuprydp_content_option_size'] = '24';
		$defaults['SSuprydp_action_option_font'] = 'Archivo:700';
		$defaults['SSuprydp_action_option_size'] = '24';
		$defaults['SSuprydp_button_option_backg_color'] = '#099607';
		$defaults['link_text_background'] = '#08a800';
	}
	if ($template === 'sticky-cta' && $mode !== 'overlay') {
		$defaults['SSuprydp_content_option_color'] = '#ffffff';
		$defaults['SSuprydp_content_option_size'] = '20';
		$defaults['SSuprydp_action_option_size'] = '20';
		$defaults['SSuprydp_button_option_backg_color'] = '#4e0d61';
		$defaults['link_text_background'] = '#11265d';
	}

	return $defaults;
}
add_filter('easy_sticky_sidebar_cta_defaults', 'easy_sticky_sidebar_image_mode_defaults');

/**
 * Get fallback overlay alignment from overlay position.
 *
 * @since 2.3.0
 *
 * @param string $position Overlay position.
 * @return string
 */
function easy_sticky_sidebar_overlay_alignment_from_position($position) {
	$position = strtolower((string) $position);
	if ($position === 'left') {
		return 'left';
	}
	if ($position === 'right') {
		return 'right';
	}
	return 'center';
}

/**
 * Add sticky CTA image mode class on frontend.
 * @since 2.3.0
 */
function easy_sticky_sidebar_overlay_mode_classes($classes, $stickycta) {
	if (($stickycta->sidebar_template ?? '') !== 'sticky-cta') {
		return $classes;
	}
	$mode = strtolower((string) ($stickycta->image_placement ?? 'classic'));
	if ($mode === 'background') {
		$mode = 'overlay';
	}
	if ($mode !== 'overlay') {
		return $classes;
	}
	$position = strtolower((string) ($stickycta->overlay_position ?? 'right'));
	if (!in_array($position, array('top', 'left', 'bottom', 'right'), true)) {
		$position = 'right';
	}
	$classes[] = 'image-as-background';
	$classes[] = 'overlay-pos-' . $position;
	return $classes;
}
add_filter('easy_sticky_sidebar_class', 'easy_sticky_sidebar_overlay_mode_classes', 10, 2);

/**
 * Generate sticky overlay mode CSS.
 * @since 2.3.0
 */
function easy_sticky_sidebar_generate_overlay_mode_css($stickycta, $generator) {
	if (($stickycta->sidebar_template ?? '') !== 'sticky-cta') {
		return;
	}

	$mode = strtolower((string) ($stickycta->image_placement ?? 'classic'));
	if ($mode === 'background') {
		$mode = 'overlay';
	}
	if ($mode !== 'overlay') {
		return;
	}

	$selector = sprintf('#easy-sticky-sidebar-%d.easy-sticky-sidebar.image-as-background', absint($stickycta->id));

	$overlay_color = (string) ($stickycta->overlay_backdrop_color ?? '');
	if ($overlay_color === '') {
		$overlay_color = '#ffffff';
	}
	$overlay_opacity = max(0, min(100, absint($stickycta->overlay_backdrop_opacity ?? 70)));
	$overlay_width = absint($stickycta->overlay_width ?? 60);
	$overlay_width = max(20, min(100, $overlay_width));
	$content_gap = max(0, absint($stickycta->overlay_content_gap ?? 10));
	$overlay_height = max(60, absint($stickycta->cta_image_height ?? 200));
	$content_pad = 12;

	printf("%s {\n", esc_html($selector));
	printf("\t--ess-overlay-backdrop-color: %s;\n", esc_attr($overlay_color));
	printf("\t--ess-overlay-backdrop-opacity: %s;\n", esc_attr((string) round($overlay_opacity / 100, 2)));
	printf("\t--ess-overlay-size: %d%%;\n", absint($overlay_width));
	printf("\t--ess-overlay-content-gap: %dpx;\n", absint($content_gap));
	printf("\t--ess-overlay-height: %dpx;\n", absint($overlay_height));
	printf("\t--ess-overlay-content-padding: %dpx;\n", absint($content_pad));
	echo "}\n\n";

	$resolved_image = !empty($stickycta->sticky_s_media) ? (string) $stickycta->sticky_s_media : '';
	if ($resolved_image === '' && absint($stickycta->image_attachment_id ?? 0) > 0) {
		$resolved_image = (string) wp_get_attachment_image_url(absint($stickycta->image_attachment_id), 'full');
	}
	if ($resolved_image === '' || stripos($resolved_image, 'ss_dummy.jpg') !== false) {
		$resolved_image = EASY_STICKY_SIDEBAR_PLUGIN_URL . '/assets/img/overlay_dummy.webp';
	}

	if (!empty($resolved_image)) {
		printf("%s .sticky-sidebar-content {\n", esc_html($selector));
		printf("\tbackground-image: url(%s);\n", esc_url($resolved_image));
		echo "}\n\n";
	}

	printf("%s .sticky-sidebar-text {\n", esc_html($selector));
	$overlay_text_color = (string) ($stickycta->SSuprydp_content_option_color ?? '');
	if ($overlay_text_color === '') {
		$overlay_text_color = '#000000';
	}
	if (!empty($overlay_text_color)) {
		printf("\tcolor: %s;\n", esc_attr($overlay_text_color));
	}
	echo "\tbackground-color: transparent;\n";
	echo "}\n\n";

	printf("%s .sticky-overlay-panel {\n", esc_html($selector));
	printf("\tpadding: %dpx;\n", absint($content_pad));
	echo "}\n\n";

	printf("%s .sticky-sidebar-call-to-action {\n", esc_html($selector));
	$overlay_btn_color = (string) ($stickycta->SSuprydp_action_option_color ?? '');
	if ($overlay_btn_color === '') {
		$overlay_btn_color = (string) ($stickycta->SSuprydp_button_option_color ?? '');
	}
	if ($overlay_btn_color !== '') {
		printf("\tcolor: %s;\n", esc_attr($overlay_btn_color));
	}
	$overlay_btn_bg = (string) ($stickycta->link_text_background ?? '');
	if ($overlay_btn_bg === '') {
		$overlay_btn_bg = (string) ($stickycta->SSuprydp_button_option_backg_color ?? '');
	}
	if ($overlay_btn_bg !== '') {
		printf("\tbackground-color: %s;\n", esc_attr($overlay_btn_bg));
	}
	$padding_values = $stickycta->overlay_button_padding ?? array();
	if (!is_array($padding_values) || empty($padding_values)) {
		$legacy_v = max(0, absint($stickycta->overlay_button_padding_v ?? 5));
		$legacy_h = max(0, absint($stickycta->overlay_button_padding_h ?? 20));
		$padding_values = array(
			'top'    => $legacy_v,
			'right'  => $legacy_h,
			'bottom' => $legacy_v,
			'left'   => $legacy_h,
			'unit'   => 'px',
		);
	}
	$padding = Easy_Sticky_Sidebar_Utils::get_dimensions_values((array) $padding_values);
	$pad_top = max(0, absint($padding->top ?? 5));
	$pad_right = max(0, absint($padding->right ?? 20));
	$pad_bottom = max(0, absint($padding->bottom ?? 5));
	$pad_left = max(0, absint($padding->left ?? 20));
	$radius = max(0, absint($stickycta->overlay_button_radius ?? 50));
	$content_alignment = strtolower((string) ($stickycta->overlay_content_alignment ?? ''));
	if (!in_array($content_alignment, array('left', 'center', 'right'), true)) {
		$content_alignment = easy_sticky_sidebar_overlay_alignment_from_position($stickycta->overlay_position ?? 'right');
	}
	$button_alignment = strtolower((string) ($stickycta->overlay_button_alignment ?? ''));
	if (!in_array($button_alignment, array('left', 'center', 'right'), true)) {
		$button_alignment = easy_sticky_sidebar_overlay_alignment_from_position($stickycta->overlay_position ?? 'right');
	}

	printf("%s .sticky-sidebar-text {\n", esc_html($selector));
	printf("\ttext-align: %s;\n", esc_attr($content_alignment));
	echo "}\n\n";

	printf("\tpadding: %dpx %dpx %dpx %dpx !important;\n", absint($pad_top), absint($pad_right), absint($pad_bottom), absint($pad_left));
	printf("\tborder-radius: %dpx !important;\n", absint($radius));
	printf("\ttext-align: %s;\n", esc_attr($button_alignment));
	if ($button_alignment === 'left') {
		echo "\tmargin-left: 0;\n";
		echo "\tmargin-right: auto;\n";
	} elseif ($button_alignment === 'center') {
		echo "\tmargin-left: auto;\n";
		echo "\tmargin-right: auto;\n";
	} else {
		echo "\tmargin-left: auto;\n";
		echo "\tmargin-right: 0;\n";
	}
	echo "}\n\n";
}
add_action('easy_sticky_sidebar_generate_css', 'easy_sticky_sidebar_generate_overlay_mode_css', 20, 2);

/**
 * Sticky CTA image display mode.
 * @since 2.3.0
 */
function easy_sticky_sidebar_image_display_mode($stickycta) { ?>
	<?php
	$mode = strtolower((string) ($stickycta->image_placement ?? 'classic'));
	if ($mode === 'background') {
		$mode = 'overlay';
	}
	if (!in_array($mode, array('classic', 'overlay'), true)) {
		$mode = 'classic';
	}
	$position = strtolower((string) ($stickycta->overlay_position ?? 'right'));
	if (!in_array($position, array('left', 'right', 'top', 'bottom'), true)) {
		$position = 'right';
	}
	?>
	<input type="hidden" name="image_placement" class="cta-image-display-mode" value="<?php echo esc_attr($mode); ?>">
	<input type="hidden" name="overlay_position" value="<?php echo esc_attr($position); ?>">
<?php
}
add_action('easy_sticky_sidebar_cta_image', 'easy_sticky_sidebar_image_display_mode', 1);

function easy_sticky_sidebar_hide_cta_image_option($stickycta) { ?>
	<?php if (!easy_sticky_sidebar_has_pro()) { return; } ?>
	<div class="SSuprydp_field_wrap cta-image-classic-only">
		<div class="heading"><?php esc_html_e("Hide / Show Image", "easy-sticky-sidebar"); ?></div>
		<label class="SSuprydp_switch">
			<input type="hidden" name="hide_cta_image" value="no">
			<input type="checkbox" name="hide_cta_image" value="yes" <?php checked('yes', $stickycta->hide_cta_image ?? 'no') ?>>
		</label>
	</div>
<?php
}
// NOTE: Hide/Show Image control is rendered by Pro field callbacks.
// Avoid duplicate field output in Pro and keep free view locked-only.

function easy_sticky_sidebar_cta_image_height_option($stickycta) { ?>
	<?php if (!easy_sticky_sidebar_has_pro()) { return; } ?>
	<div class="SSuprydp_field_wrap">
		<label><?php esc_html_e("CTA / Image Height", "easy-sticky-sidebar"); ?></label>
		<input style="width: 60px;text-align:right" type="number" min="60" name="cta_image_height" value="<?php echo esc_attr(absint($stickycta->cta_image_height ?? 300)); ?>"> px
	</div>
<?php
}
add_action('easy_sticky_sidebar_cta_image', 'easy_sticky_sidebar_cta_image_height_option', 10);

function easy_sticky_sidebar_overlay_mode_fields($stickycta) { ?>
	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Color", "easy-sticky-sidebar"); ?></label>
		<input type="text" name="overlay_backdrop_color" value="<?php echo esc_attr($stickycta->overlay_backdrop_color ?? '#ffffff'); ?>" class="sticky-sidebar-colorpicker" />
	</div>

	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Opacity", "easy-sticky-sidebar"); ?></label>
		<input style="width: 60px;text-align:right" type="number" min="0" max="100" name="overlay_backdrop_opacity" value="<?php echo esc_attr(max(0, min(100, absint($stickycta->overlay_backdrop_opacity ?? 70)))); ?>"> %
	</div>

	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Size", "easy-sticky-sidebar"); ?></label>
		<input style="width: 60px;text-align:right" type="number" min="20" max="100" name="overlay_width" value="<?php echo esc_attr(max(20, min(100, absint($stickycta->overlay_width ?? 60)))); ?>"> %
	</div>

	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Content Gap", "easy-sticky-sidebar"); ?></label>
		<input style="width: 60px;text-align:right" type="number" min="0" name="overlay_content_gap" value="<?php echo esc_attr(absint($stickycta->overlay_content_gap ?? 10)); ?>"> px
	</div>

	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Content Alignment", "easy-sticky-sidebar"); ?></label>
		<?php
		$content_alignment = strtolower((string) ($stickycta->overlay_content_alignment ?? ''));
		if (!in_array($content_alignment, array('left', 'center', 'right'), true)) {
			$content_alignment = easy_sticky_sidebar_overlay_alignment_from_position($stickycta->overlay_position ?? 'right');
		}
		?>
		<select name="overlay_content_alignment" class="SSuprydp_input">
			<option value="left" <?php selected('left', $content_alignment); ?>><?php esc_html_e('Left', 'easy-sticky-sidebar'); ?></option>
			<option value="center" <?php selected('center', $content_alignment); ?>><?php esc_html_e('Center', 'easy-sticky-sidebar'); ?></option>
			<option value="right" <?php selected('right', $content_alignment); ?>><?php esc_html_e('Right', 'easy-sticky-sidebar'); ?></option>
		</select>
	</div>

	<div class="SSuprydp_field_wrap cta-image-overlay-only">
		<label><?php esc_html_e("Overlay Button Alignment", "easy-sticky-sidebar"); ?></label>
		<?php
		$button_alignment = strtolower((string) ($stickycta->overlay_button_alignment ?? ''));
		if (!in_array($button_alignment, array('left', 'center', 'right'), true)) {
			$button_alignment = easy_sticky_sidebar_overlay_alignment_from_position($stickycta->overlay_position ?? 'right');
		}
		?>
		<select name="overlay_button_alignment" class="SSuprydp_input">
			<option value="left" <?php selected('left', $button_alignment); ?>><?php esc_html_e('Left', 'easy-sticky-sidebar'); ?></option>
			<option value="center" <?php selected('center', $button_alignment); ?>><?php esc_html_e('Center', 'easy-sticky-sidebar'); ?></option>
			<option value="right" <?php selected('right', $button_alignment); ?>><?php esc_html_e('Right', 'easy-sticky-sidebar'); ?></option>
		</select>
	</div>
<?php
}
add_action('easy_sticky_sidebar_cta_image', 'easy_sticky_sidebar_overlay_mode_fields', 20);

/**
 * Design Template option
 * @since 1.4.5
 */
function easy_sticky_sidebar_design_template_option($stickycta) {
	$design_templates = easy_sticky_sidebar_get_design_templates(); ?>
	<div class="gap-5"></div>
	<p class="wordpress-cta-instruction"><?php esc_html_e('Choose a design template.', 'easy-sticky-sidebar'); ?></p>
	<div class="SSuprydp_field_wrap">
		<select id="cta-premade-style" class="SSuprydp_input">
			<option value=""><?php esc_html_e('Select style', 'easy-sticky-sidebar'); ?></option>
			<?php foreach ($design_templates as $key => $template) {
				$name = empty($template['name']) ? $key : $template['name'];
				$disabled = isset($template['is_pro']) && !easy_sticky_sidebar_has_pro();
				if ($disabled) {
					$name = sprintf('%s (%s)', $name, __('Pro Feature', 'easy-sticky-sidebar'));
				}

				printf(
					'<option value="%s"%s>%s</option>',
					esc_attr(wp_json_encode($template)),
					$disabled ? ' disabled="disabled"' : '',
					esc_html($name)
				);
			} ?>
		</select>
	</div>
<?php
}
add_action('easy_sticky_sidebar_design_template', 'easy_sticky_sidebar_design_template_option', 1);


/**
 * Design Template option
 * @since 1.4.5
 */
function easy_sticky_sidebar_cta_collapse($stickycta) { ?>
	<div class="SSuprydp_field_wrap">
		<h4 class="heading"><?php esc_html_e("Collapse CTA On Page Load", "easy-sticky-sidebar"); ?></h4>
		<label class="SSuprydp_switch">
			<input type="hidden" name="collapse_on_page_load" value="no">
			<input type="checkbox" name="collapse_on_page_load" value="yes" <?php checked('yes', $stickycta->collapse_on_page_load) ?>>
		</label>
	</div>

<?php
}
add_action('easy_sticky_sidebar_page_load_options', 'easy_sticky_sidebar_cta_collapse');
