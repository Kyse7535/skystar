<?php
namespace App\Utils;

use App\Entity\ObjetDistant;
use App\Entity\Parcours;

class Position {
    # RA
    final const RA_MAX = 360;
    final const RA_MIN = 0;

    # DECA
    final const DECA_MAX = 90;
    final const DECA_MIN = -90;

    # RA Range
    final const RA_MAX_RANGE = 20;
    final const RA_MIN_RANGE = 2;
    final const RA_DEFAULT_RANGE = 2;

    # DECA Range
    final const DECA_MAX_RANGE = 20;
    final const DECA_MIN_RANGE = 2;
    final const DECA_DEFAULT_RANGE = 2;

    # Rayon pour random
    final const RA_DEFAULT_RAYON = 20;
    final const DECA_DEFAULT_RAYON = 20;

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

    public static function generate_random_ra(int $raMin, int $raMax): int {
        if($raMin < Position::RA_MIN)
            $raMin = Position::RA_MIN;
        if($raMax > Position::RA_MAX)
            $raMax = Position::RA_MAX;
        return random_int($raMin, $raMax);
    }

    public static function generate_random_deca(int $decaMin, int $decaMax): int {
        if($decaMin < Position::DECA_MIN)
            $decaMin = Position::DECA_MIN;
        if($decaMax > Position::DECA_MAX)
            $decaMax = Position::DECA_MAX;
        return random_int($decaMin, $decaMax);
    }

    /**
     * Génère un premier parcour, à partir d'un objet distant.
     * Le premier parcour est généré de manière aléatoire, dans un rayon donnée ou pas.
     */
    public static function generate_random_parcour(ObjetDistant $o, int $raRayon = Position::RA_DEFAULT_RAYON, int $decaRayon = Position::DECA_DEFAULT_RAYON): Parcours {
        // Default RA position
        $raMax = $o->getRa() + $raRayon;
        $raMin = $o->getRa() - $raRayon;
        $ra = Position::generate_random_ra($raMin, $raMax);

        // Default DECA position
        $decaMax = $o->getDeca() + $decaRayon;
        $decaMin = $o->getDeca() - $decaRayon;
        $deca = Position::generate_random_deca($decaMin, $decaMax);

        // Générer le parcour
        $parcour = new Parcours();
        $parcour->setRa($ra);
        $parcour->setDeca($deca);
        $parcour->setMagnitude(
            floor($o->getMagnitude()));

        return $parcour;
    }
}