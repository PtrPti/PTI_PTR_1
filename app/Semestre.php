<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Semestre extends Model
{
    protected $table = 'semestre';
    public $timestamps = false;

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
