<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        $title = 'Dashboard';
        $search = false;
        $links = [];
        return view('teacher.index', compact('title', 'search', 'links'));
    }
}
