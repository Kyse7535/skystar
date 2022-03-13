<?php
namespace App\Utils;

class Position {
    # RA
    final const RA_MAX = 360;

    # RA Range
    final const RA_MAX_RANGE = 20;
    final const RA_MIN_RANGE = 2;
    final const RA_DEFAULT_RANGE = 2;

    # DECA Range
    final const DECA_MAX_RANGE = 20;
    final const DECA_MIN_RANGE = 2;
    final const DECA_DEFAULT_RANGE = 2;

    /**
     * Renvoie RA Range en fonction d'une valeur
     */
    public static function get_ra_range($raRange): int | float {
        if(empty($raRange) || !is_numeric($raRange)) {
            $raRange = Position::RA_DEFAULT_RANGE;
        }
        else {
            if($raRange > Position::RA_MAX_RANGE) {
                $raRange = Position::RA_MAX_RANGE;
            }
            if($raRange < Position::RA_MIN_RANGE) {
                $raRange = Position::RA_MIN_RANGE;
            }
        }

        return $raRange;
    }

    /**
     * Renvoie DECA Range en fonction d'une valeur 
     */
    public static function get_deca_range($decaRange) {
        if(empty($decaRange) || !is_numeric($decaRange)) {
            $decaRange = Position::DECA_DEFAULT_RANGE;
        }
        else {
            if($decaRange > Position::DECA_MAX_RANGE) {
                $decaRange = Position::DECA_MAX_RANGE;
            }
            if($decaRange < Position::DECA_MIN_RANGE) {
                $decaRange = Position::DECA_MIN_RANGE;
            }
        } 

        return $decaRange;
    }
}