<?php

if ( !class_exists( 'PIP_Flexible_Footer' ) ) {
    class PIP_Flexible_Footer {

        private static $flexible_footer_field_name = 'pip_flexible_footer';
        private        $flexible_footer_group_key  = 'group_pip_flexible_footer';

        public function __construct() {
            // WP hooks
            add_action( 'init', array( $this, 'init' ) );

            // ACF hooks
            $flexible_footer_field_name = self::get_flexible_footer_field_name();
            add_filter( "acf/prepare_field/name={$flexible_footer_field_name}", array( 'PIP_Flexible', 'prepare_flexible_field' ), 20 );
        }

        /**
         * Register footer flexible field group
         * Add layouts to footer flexible
         */
        public function init() {
            // Get layouts
            $data    = PIP_Flexible::get_layouts_and_group_keys();
            $layouts = $data['layouts'];

            // Footer flexible content field group
            $args = array(
                'key'                   => $this->flexible_footer_group_key,
                'title'                 => 'Flexible Content Footer',
                'fields'                => array(
                    array(
                        'key'                               => 'field_' . self::get_flexible_footer_field_name(),
                        'label'                             => 'Footer',
                        'name'                              => self::get_flexible_footer_field_name(),
                        'type'                              => 'flexible_content',
                        'instructions'                      => '',
                        'required'                          => 0,
                        'conditional_logic'                 => 0,
                        'wrapper'                           => array(
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ),
                        'acfe_permissions'                  => '',
                        'acfe_flexible_stylised_button'     => 1,
                        'acfe_flexible_layouts_thumbnails'  => 1,
                        'acfe_flexible_layouts_settings'    => 1,
                        'acfe_flexible_layouts_ajax'        => 0,
                        'acfe_flexible_layouts_templates'   => 1,
                        'acfe_flexible_layouts_placeholder' => 0,
                        'acfe_flexible_disable_ajax_title'  => 1,
                        'acfe_flexible_close_button'        => 1,
                        'acfe_flexible_title_edition'       => 1,
                        'acfe_flexible_copy_paste'          => 1,
                        'acfe_flexible_modal_edition'       => 0,
                        'acfe_flexible_modal'               => array(
                            'acfe_flexible_modal_enabled'    => '1',
                            'acfe_flexible_modal_title'      => "Pilo'Press",
                            'acfe_flexible_modal_col'        => '6',
                            'acfe_flexible_modal_categories' => '1',
                        ),
                        'acfe_flexible_layouts_state'       => '',
                        'acfe_flexible_hide_empty_message'  => 1,
                        'acfe_flexible_empty_message'       => '',
                        'acfe_flexible_layouts_previews'    => 1,
                        'layouts'                           => $layouts,
                        'button_label'                      => 'Add Row',
                        'min'                               => '',
                        'max'                               => '',
                    ),
                ),
                'location'              => array(
                    array(
                        array(
                            'param'    => 'options_page',
                            'operator' => '==',
                            'value'    => PIP_Pattern::get_pattern_option_page()['menu_slug'],
                        ),
                    ),
                ),
                'menu_order'            => 2,
                'position'              => 'normal',
                'style'                 => 'seamless',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'active'                => true,
                'description'           => '',
                'acfe_display_title'    => '',
                'acfe_autosync'         => '',
                'acfe_permissions'      => '',
                'acfe_form'             => 0,
                'acfe_meta'             => '',
                'acfe_note'             => '',
            );

            // Register field group
            acf_add_local_field_group( $args );
        }

        /**
         * Getter: $flexible_footer_field_name
         * @return string
         */
        public static function get_flexible_footer_field_name() {
            return self::$flexible_footer_field_name;
        }

    }

    // Instantiate class
    new PIP_Flexible_Footer();
}

/**
 * Return flexible footer content
 *
 * @return false|string|void
 */
function get_pip_footer() {
    echo get_flexible( PIP_Flexible_Footer::get_flexible_footer_field_name(), PIP_Pattern::get_pattern_option_page()['post_id'] );
}
