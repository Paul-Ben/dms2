<?php

namespace App\Http\Controllers;

use App\Models\VisitorActivity;
use Illuminate\Http\Request;

class VisitorActivityController extends Controller
{
    public function index()
    {
        $activities = VisitorActivity::with('user')->orderBy('id', 'asc')->get();
        return view('superadmin.visitor_activity.index', compact('activities'));
    }
}
