<?php

namespace Digital\CustomAPI\Helper;

class ProductZone {

    public function getProductZone( $location ) {
        $zones = [
            'Silverwater PGA' => 'NSW',
            'Silverwater PGA_Q' => 'NSW',
            'Eagle Farm PGA_Q' => 'QLD',
            'Eagle Farm PGA' => 'QLD',
            'Tullamarine PGA_Q' => 'VIC',
            'Tullamarine PGA' => 'VIC',
            'Tullamarine DL' => 'VIC',
            'Tullamarine DL_Q' => 'VIC',
            'Canning Vale DL' => 'WA',
            'Canning Vale PGA Q' => 'WA',
            'Canning Vale PGA' => 'WA',
            'Canning Vale DL Q' => 'WA'
        ];
        
        if(isset($zones[$location])) {
            return $zones[$location];
        }

        return false;
    }
}