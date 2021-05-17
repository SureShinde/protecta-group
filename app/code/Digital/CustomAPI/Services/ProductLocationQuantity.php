<?php

namespace Digital\CustomAPI\Services;

use Digital\CustomAPI\Helper\ProductZone;
use Digital\CustomAPI\Helper\CustomLogger;
use Digital\CustomAPI\Services\NetSuiteServices;

class ProductLocationQuantity {

    public function getProductLocationQuantity( $internalId ) {
        try {
            $binLocations = (array)(new NetSuiteServices)->getItemBinLocation( $internalId );
            if($binLocations) {
                $zoneQty = [];
                foreach($binLocations as $key => $value) {
                    $zoneId = $this->getProductZone($key);
                    if(!$zoneId) continue;
                    $qty = $value;

                    $zoneQty[$zoneId] = isset($zoneQty[$zoneId]) ? $zoneQty[$zoneId] + $qty : $qty;
                }

                return $zoneQty;
            }
        } catch( Exception $e) {
            CustomLogger::webo_custom_logger('locationQty', $e->getMessage());
        }

        return [];
    }

    public function getProductZone( $location ) {
        $zones = [
            'Silverwater PGA' => 'pg_sydney_qty', //NSW
            'Silverwater PGA_Q' => 'pg_sydney_qty',
            'Eagle Farm PGA_Q' => 'pg_brisbane_qty', //QLD
            'Eagle Farm PGA' => 'pg_brisbane_qty',
            'Tullamarine PGA_Q' => 'pg_melbourne_qty', //VIC
            'Tullamarine PGA' => 'pg_melbourne_qty',
            'Tullamarine DL' => 'pg_melbourne_qty',
            'Tullamarine DL_Q' => 'pg_melbourne_qty',
            'Canning Vale DL' => 'pg_perth_qty', //WA
            'Canning Vale PGA Q' => 'pg_perth_qty',
            'Canning Vale PGA' => 'pg_perth_qty',
            'Canning Vale DL Q' => 'pg_perth_qty'
        ];

        if(isset($zones[$location])) {
            return $zones[$location];
        }

        return false;
    }
}
