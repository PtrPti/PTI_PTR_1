<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Grupo;
use App\Calendar;
use App\UsersGrupos;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use DateInterval;

class CalendarController extends Controller
{
    public function create(Request $request, $title, $start, $end, $allDay, $grupo_id) {
        $endDate = $end == 'null' ? null : DateTime::createFromFormat('d-m-Y H:i:s', $end);
        $allDayBool = $allDay == 'true' ? true : false;

        if (!$allDayBool && $end == 'null') {
            $endDate = date_add(DateTime::createFromFormat('d-m-Y H:i:s', $start), new DateInterval('P1H'));
        }

        // Calendar::insert([
        //     ['title' => $title, 'start' => DateTime::createFromFormat('d-m-Y H:i:s', $start), 'end' => $endDate, 'allDay' => $allDayBool, 'grupo_id' => $grupo_id],
        // ]);     
        // return response()->json(['message' => 'create success']);
        
        $calendar = new Calendar;
        $calendar->title = $title;
        $calendar->start = DateTime::createFromFormat('d-m-Y H:i:s', $start);
        $calendar->end = $endDate;
        $calendar->allDay = $allDayBool;
        $calendar->grupo_id = $grupo_id;
        $calendar->save();

        // $id = DB::table('calendario')->insertGetId([
        //     ['title' => $title, 'start' => DateTime::createFromFormat('d-m-Y H:i:s', $start), 'end' => $endDate, 'allDay' => $allDayBool, 'grupo_id' => $grupo_id],
        // ]);        

        return response()->json(['message' => 'create success', 'id' => $calendar->id]);
    }

    public function update(Request $request, $id, $title, $start, $end, $allDay) {
        $endDate = $end == 'null' ? null : DateTime::createFromFormat('d-m-Y H:i:s', $end);
        $allDayBool = $allDay == 'true' ? true : false;

        if (!$allDayBool && $endDate == null) {
            $endDate = date_add(DateTime::createFromFormat('d-m-Y H:i:s', $start), new DateInterval('PT1H'));
        }

        Calendar::where('id', $id)->update(['title' => $title, 'start' => DateTime::createFromFormat('d-m-Y H:i:s', $start), 'end' => $endDate, 'allDay' => $allDayBool]);

        return response()->json(['message' => 'update success']);
    }

    public function load(Request $request, $grupo_id) {
        $events = Calendar::where('grupo_id', $grupo_id)->get();
        $data = array();

        foreach ($events as $event) {
            $data[] = array(
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'allDay' => $event->allDay
            );
        }

        return response()->json($data);
    }

    public function delete(Request $request, $id) {
        Calendar::where('id', $id)->delete();
     
        return response()->json(['message' => 'delete success']);
    }
}
