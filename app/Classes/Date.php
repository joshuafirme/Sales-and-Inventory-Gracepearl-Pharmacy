<?php 

namespace App\Classes;

class Date {

    public function getDate(){
        return $date = $this->getYear().'-'.$this->getMonth().'-'.$this->getDay();
    }

    public function getYear(){
        return $year = date('yy')-100;
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $month = date('d');
    }

}

