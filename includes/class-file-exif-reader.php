<?php

/**
 * Class File_Exif_Reader
 *
 * @since    1.0.0
 */
class File_Exif_Reader {

    /**
     * @since    1.0.0
     * @param $file
     * @return array|bool
     */
    public static function read_exif_data( $file ) {

        if (is_callable('exif_read_data'))
        {
            $exif = @exif_read_data($file , 0, FALSE);

            if ( FALSE == $exif ) {
                return FALSE;
            }

            $data = array();

            // copied from nextgen-gallery-geo/functions.php
            if (isset ($exif['GPSLongitude'][0]))
            {
                // south or west?
                if ($exif['GPSLatitudeRef'] == "S") {$gps['latitude_string'] = -1; $gps['latitude_direction'] = "S";} else {$gps['latitude_string'] = 1; $gps['latitude_direction'] = "N";}
                if ($exif['GPSLongitudeRef'] == "W") {$gps['longitude_string'] = -1; $gps['longitude_direction'] = "W";} else {$gps['longitude_string'] = 1; $gps['longitude_direction'] = "E";}

                $gps['latitude_hour'] = $exif["GPSLatitude"][0];
                $gps['latitude_minute'] = $exif["GPSLatitude"][1];
                $gps['latitude_second'] = $exif["GPSLatitude"][2];
                $gps['longitude_hour'] = $exif["GPSLongitude"][0];
                $gps['longitude_minute'] = $exif["GPSLongitude"][1];
                $gps['longitude_second'] = $exif["GPSLongitude"][2];

                // calculating
                foreach($gps as $key => $value) {
                    $pos = strpos($value, '/');
                    if($pos !== false)
                    {
                        $temp = explode('/',$value); $gps[$key] = $temp[0] / $temp[1];
                    }
                }

                $data['lat'] = $gps['latitude_string'] * ($gps['latitude_hour'] + ($gps['latitude_minute'] / 60) + ($gps['latitude_second'] / 3600));
                $data['lon'] = $gps['longitude_string'] * ($gps['longitude_hour'] + ($gps['longitude_minute'] / 60) + ($gps['longitude_second'] / 3600));
            }
            
            return $data;
        }
        
        return FALSE;
    }

}
