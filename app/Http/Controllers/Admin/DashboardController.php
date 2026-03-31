<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = Guru::count();

        return view('pages.admin.dashboard', compact('totalGuru'));
    }
}
