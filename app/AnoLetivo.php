<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnoLetivo extends Model
{
    protected $table = 'ano_letivo';
    public $timestamps = false;

    public static function getCurrentAcademicYear($year, $month) {
        $ano = AnoLetivo::where('ano_fim', $year)->first();

        if ($month <= $ano->mes_fim) {
            return $ano->ano;
        }
        else {
            return AnoLetivo::select('ano')->where('ano_inicio', $ano->ano_fim)->get();
        }
    }

    public static function getCurrentAcademicYearId($year, $month) {
        $ano = AnoLetivo::getCurrentAcademicYear($year, $month);
        return AnoLetivo::where('ano', $ano)->first()->id;
    }
}
