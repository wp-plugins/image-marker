<?php

/**
 * Class Media_Library_Marker
 *
 * @since    1.0.0
 */
class Media_Library_Marker {

    /**
     * @since    1.0.0
     * @param $id
     * @return array|bool
     */
    public static function read_file_data( $id ) {

        $meta = get_post_meta( $id , '_wp_attached_file', true);

        if ( $meta != false) {

            $upload = wp_upload_dir();
            $file = $upload['basedir'] . '/' . $meta;

            $data = File_Exif_Reader::read_exif_data($file);

            if (is_array ($data)) {
                if( isset( $data['lat'] ) && isset( $data['lon'] )) {

                    $post = get_post( $id );
                    $data['markername'] = $post->post_title;

                    $data['popuptext'] = self::create_popuptext( $id );

                    $data = self::add_defaults( $data );

                } else {
                    $data = array('message' => __( 'Image doesn\'t contain location data' ));
                }
            } else {
                $data = array('message' => __( 'Couldn\'t read exif data' ));
            }

        } else {
            $data = array('message' => __( 'Image not found' ));
        }

        return $data;
    }

    private static function create_popuptext( $id ) {

        // get popup dimensions
        $lmm_options = get_option('leafletmapsmarker_options');
        $w = $lmm_options['defaults_marker_popups_maxwidth'];
        $h = $lmm_options['defaults_marker_popups_maxheight'];

        // thumbnail image
        $thumbnail = image_get_intermediate_size( $id, array( $w, $h ) );

        // full size image
        $url = wp_get_attachment_url( $id );

        // thumbnail image url
        if ( empty($thumbnail['url']) && !empty($thumbnail['file']) ) {
            $thumbnail['url'] = path_join( dirname($url), $thumbnail['file'] );
        }

        return "<a href='{$url}'><img class='alignnone size-medium wp-image-{$id}' src='{$thumbnail['url']}' alt='{$thumbnail['file']}' width='{$thumbnail['width']}' height='{$thumbnail['height']}' /></a>";
    }

    /**
     * @since    1.0.0
     * @param $data
     * @return mixed
     */
    public static function add_defaults( $data ) {
        // the page to post to create the map marker
        $data['target_url'] = admin_url( 'admin.php?page=leafletmapsmarker_marker' );
        $data['_wpnonce'] = wp_create_nonce('marker-nonce');
        $data['action'] = 'add';

        // default settings from leaflet-marker.php
        $lmm_options = get_option('leafletmapsmarker_options');
        $data['basemap'] = $lmm_options[ 'standard_basemap' ];
        $data['layer'] = $lmm_options[ 'defaults_marker_default_layer' ];
        $data['icon'] = $lmm_options[ 'defaults_marker_icon' ];
        $data['icon-hidden'] = $lmm_options[ 'defaults_marker_icon' ];
        $data['zoom'] = $lmm_options[ 'defaults_marker_zoom' ];
        $data['openpopup'] = $lmm_options[ 'defaults_marker_openpopup' ];
        $data['mapwidth'] = $lmm_options[ 'defaults_marker_mapwidth' ];
        $data['mapwidthunit'] = $lmm_options[ 'defaults_marker_mapwidthunit' ];
        $data['mapheight'] = $lmm_options[ 'defaults_marker_mapheight' ];
        $data['panel'] = $lmm_options[ 'defaults_marker_panel' ];
        $data['controlbox'] = $lmm_options[ 'defaults_marker_controlbox' ];

        return $data;
    }

}
