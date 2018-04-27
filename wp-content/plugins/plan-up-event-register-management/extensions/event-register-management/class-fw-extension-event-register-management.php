<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}

class FW_Extension_Event_Register_Management extends FW_Extension {

    private $post_type = 'event-customer';
    private $slug = 'event-customer';
    private $taxonomy_slug = 'event-customer';
    private $taxonomy_name = 'event-customer-category';

    /**
     * @internal
     */
    public function _init() {
        if ( is_admin() ) {
            $this->add_admin_actions();
            add_filter( 'fw_post_options', array( $this, '_filter_admin_add_post_options' ), 10, 2 );
        }
    }

    public function add_admin_actions() {
    }

    public function get_settings() {

        $response = array(
            'post_type'     => $this->post_type,
            'slug'          => $this->slug,
            'taxonomy_slug' => $this->taxonomy_slug,
            'taxonomy_name' => $this->taxonomy_name
        );

        return $response;
    }

    public function get_post_type_name() {
        return $this->post_type;
    }

    public function get_taxonomy_name() {
        return $this->taxonomy_name;
    }

    /**
     * @internal
     *
     * @param array $options
     * @param string $post_type
     *
     * @return array
     */
    public function _filter_admin_add_post_options( $options, $post_type ) {
        if( $post_type === $this->post_type ){
            $options[] = array(
                $this->get_options('posts/event-customer', $options=array())
            );
        }
        if( $post_type === 'speaker' ){
            $options[] = array(
                $this->get_options('posts/speaker', $options=array())
            );
        }
        return $options;
    }
}