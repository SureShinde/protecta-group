<?php

namespace Digital\CustomAPI\Helper;
class CustomLogger {

    public static function webo_custom_logger( $fileName, $data )
    {
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $filename = 'logs/'.$fileName.'/'.$current_date.'.log';

        $dirname = dirname($filename);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        $fp = fopen($filename, 'a'); //opens file in append mode
        if(gettype($data) != 'string') {
            $data = json_encode($data);
        }
        $content = "[".$current_date.' '.$current_time."] ".$data. "\n";
        fwrite($fp, $content);
        fclose($fp);
    }
}
