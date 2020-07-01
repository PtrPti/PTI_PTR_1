<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

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

    public function getFullDate($day, $month, $year, $format) {
        $date = new DateTime($year.'-'.$month.'-'.$day);
        return $date->format($format);
    }

    public function getDay($date) {
        $timestamp = strtotime($date);
        return date('d', $timestamp);
    }

    public function getMonth($date) {
        $timestamp = strtotime($date);
        return date('m', $timestamp);
    }

    public function getyear($date) {
        $timestamp = strtotime($date);
        return date('Y', $timestamp);
    }
}
