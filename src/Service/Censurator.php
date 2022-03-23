<?php

namespace App\Service;

class Censurator{


    function purify($description){
        $grosMots = ["idiot"];
        return str_ireplace($grosMots,"****",$description);
    }

}