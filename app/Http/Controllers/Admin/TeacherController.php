<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $teachers = User::where('role', 'teacher')->orderBy('name');
        $subjects = Subject::where('status', 'active')->get();
        $teachers = $teachers->paginate(10);
        return view('admin.teacher.index', compact('title', 'search', 'links', 'teachers', 'subjects'));
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
        $subjects = Subject::where('status', 'active')->get();
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
        $validator = Validator::make($request->all(), [
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($id ?? 'NULL') . ',id',
            'phone' => 'required|string',  // TODO: improve phone validation
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',

            'subjects'   => 'nullable|array',
            'subjects.*' => 'nullable|integer|distinct|exists:subjects,id',

            'fees'       => 'nullable|array',
            'fees.*'     => 'nullable|numeric|min:1',
        ], [
            'subjects.*.distinct' => 'You cannot select the same subject more than once.',
            'subjects.*.exists' => 'The selected subject is invalid.',
            'fees.*.min' => 'Each session fee must be at least 1.',
        ]);
        $validator->after(function ($validator) use ($request) {
            $subjects = $request->input('subjects', []);
            $fees = $request->input('fees', []);

            foreach ($subjects as $index => $subject) {
                $fee = $fees[$index] ?? null;

                if (!empty($subject) && (empty($fee) || $fee < 1)) {
                    $validator->errors()->add("fees.$index", "Session fee is required and must be at least 1.");
                }

                if (!empty($fee) && empty($subject)) {
                    $validator->errors()->add("subjects.$index", "Subject is required when a session fee is provided.");
                }
            }
        });
        $validated = $validator->validate();

        // Handle profile picture using helper
        $path = 'profile_pics/teachers';
        $validated['profile_pic'] = uploadImage($request->file('profile_pic'), $path, $id ? User::find($id)->profile_pic : null );

        if ($id) {
            // Edit
            $this->update($validated, $id, $path);
            $msg = 'Teacher updated successfully.';
        } else {
            // Add
            $this->create($validated, $path);
            $msg = 'Teacher added successfully.';
        }
        return redirect()->route('admin.teacher.index')->with('message', [
            'status' => 'success',
            'msg' => $msg
        ]);
    }

    public function create($validated, $path)
    {

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role'  => 'teacher',
            'profile_pic' => $validated['profile_pic'] ?? '',
            'phone' => $validated['phone'],
            'email_verified_at' => now(),
            'password' => Hash::make($validated['password']),
            'status' => 'active',
            'bio'   => ''
        ]);
        
        $count = min(count($validated['subjects']), count($validated['fees']));
        for ($i = 0; $i < $count; $i++) {
            TeacherSubject::create([
                'teacher_id' => $user->id,
                'subject_id' => $validated['subjects'][$i],
                'session_fee' => $validated['fees'][$i],
                'is_active' => '1',
            ]);
        }
    }

    public function update($validated, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated->name,
            'email' => $validated->email,
            'role'  => 'teacher',
            'profile_pic' => '',
            'phone' => $validated->phone,
            'email_verified_at' => now(),
            'password' => $validated->password,
            'status' => 'active',
            'bio'   => ''
        ]);
    }

    public function fees($id){
        $subjects = Subject::where('status', 'active')->get();
        $session_fees = TeacherSubject::where('teacher_id', $id)->get();
        return view('admin.components.fees-model', compact('subjects', 'session_fees'))->render();
    }


}
