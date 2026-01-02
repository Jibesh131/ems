<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $title = 'Teachers';
        $search = true;
        $links = [
            [
                'name' => $title
            ]
        ];
        // $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        return view('admin.teacher.index', compact('title', 'search', 'links'));
    }

    public function add()
    {
        $title = 'Add New Teacher';
        $links = [
            [
                'url'  => route('admin.teacher.index'),
                'name' => 'Teachers'
            ],
            [
                'name' => $title
            ]
        ];
        $subjects = Subject::all();
        return view('admin.teacher.form', compact('title', 'links', 'subjects'));
    }

    public function edit($id)
    {
        $subject = User::findOrFail($id);
        $title = 'Edit Teacher';
        $links = [
            [
                'url'  => route('admin.teacher.index'),
                'name' => 'Teachers'
            ],
            [
                'name' => $title
            ]
        ];
        return view('admin.teacher.form', compact('title', 'links', 'subject'));
    }

    public function save(Request $request, $id = null)
    {
        dd($request->all());
        $rules = [
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:10',
            'fees' => 'required|integer|min:0',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
        ];
        if (!$id) {
            $rules['email'] .= '|unique:users,email';
        }
        $validated = $request->validate($rules);
        if ($id) {
            // Edit
            $subject = User::findOrFail($id);
            $subject->update([
                'name' => $validated->name ?? '',
                'email' => $validated->email ?? '',
                'profile_pic' => '',
                'phone' => $validated->phone ?? '',
                'status' => $validated->status ?? 'active',
            ]);


            return redirect()->route('admin.teacher.index')->with('message', [
                'status' => 'success',
                'msg' => 'Teacher updated successfully.'
            ]);
        } else {
            // Add
            User::create($validated);
            return redirect()->route('admin.teacher.index')->with('message', [
                'status' => 'success',
                'msg' => 'Teacher added successfully'
            ]);
        }
    }
}
