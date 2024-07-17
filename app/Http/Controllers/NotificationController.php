<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function renewals()
    {
        $renewals = DB::table('accountsection')
            ->whereRaw('month(current_date) = month(renewal_date) - 1 and year(current_date) = year(renewal_date)')
            ->get();

        return view('notification.renewals', ['renewals' => $renewals]);
    }

    public function age()
    {
        $data = DB::table('accountsection')
            ->select('group_name', DB::raw('COUNT(birthday) as count'))
            ->whereBetween('birthday', ['1900-01-01', '1961-12-31'])
            ->groupBy('group_name')
            ->get();

        return view('notification.age', ['data' => $data]);
    }

    public function birthday()
    {
        $currentDate = date('Y-m-d');
        $birthdays = DB::table('accountsection')
            ->whereRaw('MONTH(current_date) = MONTH(birthday) AND DAY(current_date) <= DAY(birthday)')
            ->get();
        $count = $birthdays->count();
        return view('notification.birthday', compact('count', 'birthdays'));
    }
}