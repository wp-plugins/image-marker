<?php

/**
 * Class NextGen_Image_Marker
 *
 * @since    1.0.0
 */
class NextGen_Image_Marker {

    /**
     * @since    1.0.0
     * @param $id
     * @return array|bool|mixed
     */
    public static function read_file_data( $id ) {

        if (is_callable( 'nggdb::find_image' )) {

            $picture = nggdb::find_image( $id );

            if ( $picture != FALSE) {

	            $storage = C_Component_Registry::get_instance()->get_utility('I_Gallery_Storage');
                $file = $storage->get_image_abspath( $id );

                $data = File_Exif_Reader::read_exif_data( $file );

                if (is_array ($data)) {
                    if( isset( $data['lat'] ) && isset( $data['lon'] )) {

                        $alt_text = empty( $picture->alttext ) ? $picture->filename : $picture->alttext;
                        $data['markername'] = $alt_text;

                        $data['popuptext'] = self::create_popuptext( $picture );

                        $data = Media_Library_Marker::add_defaults( $data );

                    } else {
                        $data = array('message' => __( 'Image doesn\'t contain location data' ));
                    }
                } else {
                    $data = array('message' => __( 'Couldn\'t read exif data' ));
                }
            } else {
                $data = array('message' => __( 'Image not found' ));
            }

        } else {
            $data = array('message' => __( 'NextGEN not installed' ));
        }

        return $data;
    }

    private static function create_popuptext( $picture ) {

        // get popup dimensions
        $lmm_options = get_option('leafletmapsmarker_options');
        $w = $lmm_options['defaults_marker_popups_maxwidth'];
        $h = $lmm_options['defaults_marker_popups_maxheight'];

        // generate thumbnail image
        $storage   = C_Component_Registry::get_instance()->get_utility('I_Gallery_Storage');
        $dynthumbs   = C_Component_Registry::get_instance()->get_utility('I_Dynamic_Thumbnails_Manager');
        $params = array( 'width' => $w, 'height' => $h );
        $size = $dynthumbs->get_size_name($params);
        $thumbnail = $storage->generate_image_size($picture->pid, $size);

        // thumbnail image url
        $thumbnail_url = $storage->get_image_url($picture->pid, $size);

        // full size image url
        $url = $storage->get_image_url($picture->pid);

        $alt_text = empty( $picture->alttext ) ? $picture->filename : $picture->alttext;

        return "<a href='{$url}'><img class='alignnone size-medium ngg-image-{$picture->pid}' src='{$thumbnail_url}' alt='{$alt_text}' width='{$thumbnail->maxWidth}' height='{$thumbnail->maxHeight}' /></a>";
    }

}
