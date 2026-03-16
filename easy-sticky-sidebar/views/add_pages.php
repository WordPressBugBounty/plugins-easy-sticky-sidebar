<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$tabs = easy_sticky_sidebar_get_cta_tabs();
$templates = easy_sticky_sidebar_templates();
$current_template = !empty($stickycta->sidebar_template) ? $stickycta->sidebar_template : 'sticky-cta';
$current_template_label = isset($templates[$current_template]) ? $templates[$current_template] : ucfirst(str_replace('-', ' ', $current_template));
$preview_image = !empty($stickycta->sticky_s_media) ? $stickycta->sticky_s_media : (EASY_STICKY_SIDEBAR_PLUGIN_URL . '/assets/img/ss_dummy.jpg');
$is_pro_active = has_wordpress_cta_pro();
$cta_count = 0;
if (!$is_pro_active) {
    global $wpdb;
    $cta_count = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}sticky_cta");
}
$is_new_cta = empty($sticky_id);
$cta_limit_reached = (!$is_pro_active && $is_new_cta && $cta_count >= 3);
$preview_position = !empty($stickycta->SSuprydp_cta_position) ? $stickycta->SSuprydp_cta_position : 'right';
$preview_align = !empty($stickycta->horizontal_vertical_position) ? $stickycta->horizontal_vertical_position : 'top';

if (!$is_pro_active) {
    $preview_position = 'right';
    $preview_align = 'top';
}

if (!in_array($preview_position, ['left', 'right', 'top', 'bottom'], true)) {
    $preview_position = 'right';
}

if (!in_array($preview_align, ['top', 'center', 'bottom'], true)) {
    $preview_align = 'top';
}

$preview_classes = [
    'easy-sticky-sidebar',
    'sticky-cta',
    'ess-preview-static',
    'sticky-cta-position-' . $preview_position,
    'ess-preview-align-' . $preview_align,
];

if (in_array($preview_position, ['top', 'bottom'], true)) {
    $preview_classes[] = 'vertical-cta';
    $preview_classes[] = 'vertical-cta-' . $preview_position;
}

ob_start();
do_action('easy_sticky_sidebar_before_tab', $stickycta);
$before_tab_content = trim(ob_get_clean());
?>

<div class="wrap wrap-easy-sticky-sidebar ess-dashboard-redesign">
    <?php easy_sticky_sidebar_get_header(); ?>
    <hr class="wp-header-end">

    <div class="easy-sticky-sidebar-container">
        <div id="SSuprydp_builder_form">
            <div class="SSuprydp_col_2 SSuprydp-form-col">
                <form id="SSuprydp_form" method="post"
                    action="<?php echo esc_url(add_query_arg('action', 'process_pages', admin_url('admin-ajax.php'))); ?>"
                    <?php echo wp_kses_post(implode(' ', $form_attributes)); ?>>
                    <input type="hidden" id="ajaxaction"
                        value="<?php echo esc_url(add_query_arg('action', 'ajax_check', admin_url('admin-ajax.php'))); ?>" />
                    <?php wp_nonce_field('_nonce_easy_sticky_sidebar'); ?>
                    <input type="hidden" name="sticky_id" value="<?php echo esc_attr($sticky_id); ?>" />
                    <input type="hidden" name="cta_editor_current_tab" value="<?php echo esc_attr($editor_current_tab); ?>">
                    <?php if ($cta_limit_reached) : ?>
                        <div class="notice notice-warning">
                            <p><?php _e('Only 3 CTAs are allowed in free version. Please upgrade to Pro to build more CTAs.', 'easy-sticky-sidebar'); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="SSuprydp_page_fields ess-page-fields">
                        <div class="ssuprydp_load" style="display:none;">
                            <p>Loading.....</p>
                        </div>

                        <div class="ess-editor-grid">
                            <div class="ess-main-column">
                                <section class="SSuprydp_field_wrap cta-name-field ess-card">
                                    <label class="heading"><?php _e("CTA Name", "easy-sticky-sidebar"); ?></label>
                                    <input type="text" name="sidebar_name" class="SSuprydp_input"
                                        value="<?php echo esc_attr($stickycta->sidebar_name); ?>" placeholder="Enter CTA name here">
                                </section>

                                <div class="status-notice status-notice-off">
                                    <p><?php _e('Your CTA live status is set to Off and will not show on the front end.', 'easy-sticky-sidebar'); ?></p>
                                </div>

                                <div class="status-notice status-notice-development">
                                    <p><?php _e('Your CTA live status is set to Development and will show on the front end only for users logged in as admin.', 'easy-sticky-sidebar'); ?></p>
                                </div>

                                <section class="ess-live-preview-card ess-card is-preview-loading" aria-busy="true">
                                    <header class="ess-section-head">
                                        <h2><?php _e('Live Preview', 'easy-sticky-sidebar'); ?></h2>
                                    </header>

                                    <div class="ess-preview-canvas">
                                        <div class="ess-preview-spinner" aria-hidden="true">
                                            <span class="ess-spinner"></span>
                                        </div>
                                        <div class="ess-preview-stage">
                                            <div class="<?php echo esc_attr(implode(' ', $preview_classes)); ?>" id="ess-preview-cta">
                                                <div class="sticky-sidebar-button" id="ess-preview-button-wrap">
                                                    <div id="ess-preview-button-text">
                                                        <?php echo esc_html($stickycta->SSuprydp_button_option_text ? $stickycta->SSuprydp_button_option_text : __('Click Here', 'easy-sticky-sidebar')); ?>
                                                    </div>
                                                </div>

                                                <div class="sticky-sidebar-content sticky-sidebar-container">
                                                    <div class="sticky-sidebar-image" id="ess-preview-image-wrap"
                                                        style="background-image: url('<?php echo esc_url($preview_image); ?>');"></div>

                                                    <div class="sticky-sidebar-text sticky-content-inner" id="ess-preview-content-text">
                                                        <?php echo esc_html(wp_strip_all_tags((string) $stickycta->SSuprydp_content_option_text)); ?>
                                                    </div>

                                                    <hr id="ess-preview-divider">

                                                    <div class="sticky-sidebar-call-to-action sticky-content-inner" id="ess-preview-link">
                                                        <?php echo esc_html($stickycta->SSuprydp_action_option_text ? $stickycta->SSuprydp_action_option_text : __('Click Here to View', 'easy-sticky-sidebar')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section class="ess-card ess-steps-card">
                                    <nav class="nav-tab-wrapper sticky-sidebar-nav-tab-wrapper">
                                        <?php
                                        $tab_number = 1;
                                        foreach ($tabs as $key => $tab) {
                                            $tab_active = ('sticky-sidebar-' . $key === $editor_current_tab) ? 'nav-tab-active' : '';
                                            $tab_icon = !empty($tab['icon']) ? sprintf('<i class="%s"></i>', esc_attr($tab['icon'])) : '';
                                            printf(
                                                '<a href="#sticky-sidebar-%1$s" class="nav-tab nav-tab-%1$s %2$s" data-step="%3$d"><span class="ess-step-label">%4$s%5$s</span><span class="cta-chevron"></span></a>', // CUSTOM STICKY NAV: chevron element
                                                esc_attr($key),
                                                esc_attr($tab_active),
                                                absint($tab_number),
                                                $tab_icon,
                                                esc_html($tab['label'])
                                            );
                                            $tab_number++;
                                        }
                                        ?>
                                    </nav>
                                </section>

                                <div class="sticky-sidebar-tab-content">
                                    <?php
                                    foreach ($tabs as $key => $tab) {
                                        $tab_display = ('sticky-sidebar-' . $key === $editor_current_tab) ? 'display:block' : '';
                                        printf('<div id="sticky-sidebar-%s" class="tab-content" style="%s">', esc_attr($key), esc_attr($tab_display));
                                        call_user_func_array($tab['callback'], [$stickycta]);
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <aside class="ess-side-column">
                                <div class="ess-card ess-save-card">
                                    <h2 class="wordpress-cta-heading"><?php _e('Publish', 'easy-sticky-sidebar'); ?><span class="status"></span></h2>
                                    <div class="ess-publish-status">
                                        <?php easy_sticky_sidebar_get_status_menu($stickycta); ?>
                                    </div>
                                    <div class="SSuprydp_btn_save">   
                                        <input type="submit"
                                            onclick="return SSuprydp_Admin.ProcessPageData(event, this);"
                                            class="button_save<?php echo $cta_limit_reached ? ' is-disabled' : ''; ?>"
                                            value="<?php esc_attr_e('Save', 'easy-sticky-sidebar'); ?>"
                                            <?php echo $cta_limit_reached ? 'disabled="disabled" aria-disabled="true"' : ''; ?>>
                                    </div>
                                    <p class="wordpress-cta-instruction ess-publish-help">
                                        <?php _e('<strong>Change the status of your CTA.</strong><br><strong>Live:</strong> This will show to everyone.<br><strong>Development:</strong> This will only show to admins who are logged in.<br><strong>Off:</strong> Will not show to anyone.', 'easy-sticky-sidebar'); ?>
                                    </p>
                                </div>

                                <?php
                                $has_masked_hook_stats = !empty($before_tab_content) && strpos($before_tab_content, 'wordpress-cta-pro-feature-lock-inline') !== false;
                                if (!empty($before_tab_content) && !$has_masked_hook_stats) :
                                ?>
                                    <div class="ess-card ess-stat-card ess-hooked-stats">
                                        <?php echo $before_tab_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </div>
                                <?php else : ?>
                                    <div class="ess-card ess-stat-card">
                                        <h3><?php _e('CTA Stats', 'easy-sticky-sidebar'); ?></h3>
                                        <ul>
                                            <li><span><?php _e('Impressions', 'easy-sticky-sidebar'); ?></span><strong><?php echo esc_html(absint($stickycta->SSuprydp_impressions)); ?></strong></li>
                                            <li><span><?php _e('Clicks', 'easy-sticky-sidebar'); ?></span><strong><?php echo esc_html(absint($stickycta->SSuprydp_clicks)); ?></strong></li>
                                            <li><span><?php _e('CTR', 'easy-sticky-sidebar'); ?></span><strong><?php echo esc_html($stickycta->get_ctr()); ?></strong></li>
                                            <li><span><?php _e('Template', 'easy-sticky-sidebar'); ?></span><strong class="ess-template-label"><?php echo esc_html($current_template_label); ?></strong></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </aside>
                        </div>

                        <div class="SSuprydp_field_wrap" id="SSuprydp_modal_msg" style="display:none;">
                            <div class="SSuprydp_modal_content"></div>
                        </div>
                    </div>
                </form>
            </div>

            <?php if (!has_wordpress_cta_pro()) : ?>
                <div class="wordpress-cta-advertisement">
                    <span class="div-two">
                        <a href="https://wpctapro.com/" target="_blank"><img src="<?php echo esc_url(EASY_STICKY_SIDEBAR_PLUGIN_URL . '/assets/img/ads.jpeg'); ?>" alt="WP CTA Pro"></a>
                    </span>
                    <span class="div-two">
                        <a href="https://wordpress.org/plugins/ez-countdown-timer/" target="_blank"><img src="<?php echo esc_url(EASY_STICKY_SIDEBAR_PLUGIN_URL . '/assets/img/ezcountdowntimer.jpg'); ?>" alt="Alpha Link SEO"></a>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="easy-sticky-sidebar-toast"><?php _e('Clear Your Cache', 'easy-sticky-sidebar'); ?></div>

<script type='text/javascript'>
jQuery(document).ready(function($) {
    var file_frame;

    jQuery('#upload_image_button').on('click', function(event) {
        event.preventDefault();

        if (file_frame) {
            file_frame.open();
            return;
        }

        file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#image-preview').attr('src', attachment.url).css('width', 'auto');
            $('#image_attachment_id').val(attachment.id);
            $('#sticky_s_media').val(attachment.url).trigger('change');
        });

        file_frame.open();
    });
});
</script>
