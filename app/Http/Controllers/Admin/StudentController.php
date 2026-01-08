<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request){
        $title = "Users";
        $search = true;
        $links = [['name' => $title]];
        $users = User::where('status', 'active');
        if ($request->keyword) {
            $users = $users->where('name', 'LIKE', '%' . $request->keyword . '%')->orderByRaw("LOCATE(?, LOWER(name))", [strtolower($request->keyword)]);
        }
        $users = $users->orderBy('name')->paginate(10);

        return view('admin.student.index', compact('title', 'search', 'links', 'users'));
    }
}
