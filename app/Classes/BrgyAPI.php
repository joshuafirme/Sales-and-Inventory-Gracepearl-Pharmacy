<?php 

namespace App\Classes;

class BrgyAPI {

    private $api = 'https://raw.githubusercontent.com/flores-jacob/philippine-regions-provinces-cities-municipalities-barangays/master/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';

    public function getBrgyAPI()
    {
        return $this->api;
    }


}

