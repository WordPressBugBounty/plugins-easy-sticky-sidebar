<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly 
}
$btn_color = $ctacontent->SSuprydp_button_option_color;
if($btn_color){
$button_color = $btn_color ;
}

$btn_backcolor = $ctacontent->SSuprydp_button_option_backg_color;
if($btn_backcolor){
$button_background_color = $btn_backcolor ;
}

$cta_links_attrs = sprintf('href="%s"', esc_url($ctacontent->tab_cta_url));
if ($ctacontent->tab_cta_target_blank == 'yes') {
	$cta_links_attrs .= ' target="_blank"';
}

if ($ctacontent->tab_cta_nofollow == 'yes') {
	$cta_links_attrs .= ' rel="nofollow"';
}

$display_trigger = $ctacontent->display_trigger ?? 'immediately';
$display_trigger_seconds = absint($ctacontent->display_trigger_seconds ?? 0);
$display_trigger_scroll = absint($ctacontent->display_trigger_scroll ?? 0);
$display_animation = $ctacontent->display_animation ?? 'none';
$hide_behavior = $ctacontent->hide_behavior ?? 'none';
$hide_after_seconds = absint($ctacontent->hide_after_seconds ?? 0);
$display_frequency = $ctacontent->display_frequency ?? 'every_time';
$after_close_behavior = $ctacontent->after_close_behavior ?? 'next_visit';
$after_close_time = absint($ctacontent->after_close_time ?? 0);
$after_close_time_unit = $ctacontent->after_close_time_unit ?? 'hours';
$display_attrs = sprintf(
    ' data-display-trigger="%s" data-display-trigger-seconds="%d" data-display-trigger-scroll="%d" data-display-animation="%s" data-hide-behavior="%s" data-hide-after-seconds="%d" data-display-frequency="%s" data-after-close-behavior="%s" data-after-close-time="%d" data-after-close-time-unit="%s"',
    esc_attr($display_trigger),
    $display_trigger_seconds,
    $display_trigger_scroll,
    esc_attr($display_animation),
    esc_attr($hide_behavior),
    $hide_after_seconds,
    esc_attr($display_frequency),
    esc_attr($after_close_behavior),
    $after_close_time,
    esc_attr($after_close_time_unit)
);

if (in_array($display_trigger, ['after_seconds', 'after_scroll'], true)) {
    $cta_classes[] = 'ess-cta-hidden';
}
if (in_array($display_frequency, ['once_per_visit', 'every_24_hours', 'every_7_days'], true)) {
    $cta_classes[] = 'ess-cta-hidden';
}
if ($display_animation && $display_animation !== 'none') {
    $cta_classes[] = 'ess-cta-hidden';
}

$horizontal_vertical_position = $ctacontent->dynamic_properties['horizontal_vertical_position'];
$position_style = '';
$position_a = '';
    if($ctacontent->SSuprydp_cta_position == 'left' || $ctacontent->SSuprydp_cta_position == 'right'){
        if ($horizontal_vertical_position === 'top') {
            $position_style = 'top: 0; transform: none;';    
        } elseif ($horizontal_vertical_position === 'bottom') {
            $position_style = 'bottom: 0; transform: none; top:100%';
            $position_a = 'position: absolute; bottom: 0; top:unset';

        }
    }

ob_start(); ?>

<div id="<?php echo 'easy-sticky-sidebar-' . esc_attr($ctacontent->id) ?>" style="<?php echo $position_style;   ?>"
    class="<?php echo esc_attr(implode(' ', $cta_classes)) ?>" data-id="<?php echo esc_attr($ctacontent->id); ?>"<?php echo $display_attrs; ?>>
    <?php 
 
?>

    <a class="sticky-sidebar-button"
        style="color: <?php echo $button_color ?> ; background-color:<?php echo $button_background_color ?>; <?php echo $position_a; ?>"
        <?php echo $cta_links_attrs; ?>>
        <div><?php echo wp_kses_post($ctacontent->SSuprydp_button_option_text) ?></div>
    </a>
    <?php 
	if (function_exists('wordpress_cta_pro_get_close_button')) { 
		wordpress_cta_pro_get_close_button($ctacontent); 
	} ?>
</div>
<?php
     
echo ob_get_clean();
