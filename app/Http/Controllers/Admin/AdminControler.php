<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminControler extends Controller
{
    public function index(){
        $title = 'Dashboard';
        $search = true;
        $links = [
            [
                'name' => $title
            ]
        ];
        // $contents = $contents->paginate(10);

        return view('admin.index', compact('title', 'search', 'links'));
    }
}
