<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(){
        $title = 'Subject';
        $search = true;
        $links = [
            [
                'name' => $title
            ]
        ];
        $subjects = Subject::all();
        return view('admin.subject.index', compact('title', 'search', 'links', 'subjects'));
    }

    public function add(){
        $title = 'Add New Subject';
        $links = [
            [
                'url'  => route('admin.subject.index'),
                'name' => 'Subject'
            ],
            [
                'name' => $title
            ]
        ];
        return view('admin.subject.form', compact('title', 'link'));
    }
}
