<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionsController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('sessions')
            ->leftJoin('users', 'sessions.user_id', '=', 'users.id')
            ->select(
                'sessions.id',
                'sessions.user_id',
                'users.name',
                'sessions.ip_address',
                'sessions.user_agent',
                'sessions.last_activity'
            )
            ->orderBy('sessions.last_activity', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('sessions.ip_address', 'like', "%{$search}%");
            });
        }

        $sessions = $query->paginate(10)->appends(['search' => $search]);
        $total   = DB::table('sessions')->count();
        $showing = $sessions->count();

        return view('components.Security.sessions.index', compact('sessions', 'showing', 'total'));
    }
}