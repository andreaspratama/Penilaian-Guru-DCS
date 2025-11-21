<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index()
    {
        return view('pages.siswa.index');
    }
}
