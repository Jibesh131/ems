<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $title = 'Subject';
        $search = true;
        $links = [
            [
                'name' => $title
            ]
        ];
        $subjects = Subject::paginate(10);
        return view('admin.subject.index', compact('title', 'search', 'links', 'subjects'));
    }

    public function add()
    {
        $title = 'Add New Subject';
        $links = [
            [
                'url'  => route('admin.subject.index'),
                'name' => 'Subjects'
            ],
            [
                'name' => $title
            ]
        ];
        return view('admin.subject.form', compact('title', 'links'));
    }

    public function edit($id){
        $subject = Subject::findOrFail($id);
        $title = 'Edit Subject';
        $links = [
            [
                'url'  => route('admin.subject.index'),
                'name' => 'Subjects'
            ],
            [
                'name' => $title
            ]
        ];
        return view('admin.subject.form', compact('title', 'links', 'subject'));
    }

    public function save(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable',
        ];
        if (!$id) {
            $rules['name'] .= '|unique:subjects,name';
        }
        $validated = $request->validate($rules, [
            'name.unique' => 'This subject name already exists.',
        ]);

        if ($id) {
            // Edit
            $subject = Subject::findOrFail($id);
            $subject->update($validated);
            return redirect()->route('admin.subject.index')->with('message', [
                'status' => 'success',
                'msg' => 'Subject updated successfully.'
            ]);
        } else {
            // Add
            Subject::create($validated);
            return redirect()->route('admin.subject.index')->with('message', [
                'status' => 'success',
                'msg' => 'Subject added successfully'
            ]);
        }
    }

    public function delete($id){
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('admin.subject.index')->with('message', [
            'status' => 'success',
            'msg' => 'Subject Deleted Successfully'
        ]); 
    }
}
