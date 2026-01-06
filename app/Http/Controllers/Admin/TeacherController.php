<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Teachers';
        $search = true;
        $links = [
            [
                'name' => $title
            ]
        ];
        $teachers = User::where('role', 'teacher');
        if ($request->keyword) {
            $teachers = $teachers->where('name', 'LIKE', '%' . $request->keyword . '%')->orderByRaw("LOCATE(?, LOWER(name))", [strtolower($request->keyword)]);
        }
        $subjects = Subject::where('status', 'active')->get();
        $teachers = $teachers->orderBy('name')->paginate(10);
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

        $teacher = User::findOrFail($id);
        $subjects = Subject::where('status', 'active')->get();
        $session_fees = TeacherSubject::where('teacher_id', $id)->get();
        return view('admin.teacher.form', compact('title', 'links', 'teacher', 'subjects', 'session_fees'));
    }

    public function save(TeacherRequest $request, $id = null)
    {

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $path = 'profile_pics/teachers';
            $validated['profile_pic'] = uploadImage($request->file('profile_pic'), $path, $id ? User::find($id)->profile_pic : null);
            $id ? $this->update($validated, $id): $this->create($validated);
            DB::commit();
            return redirect()->route('admin.teacher.index')->with('message', [
                'status' => 'success',
                'msg' => $id ? 'Teacher updated successfully.' : 'Teacher added successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Teacher save failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function create($validated)
    {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role'  => 'teacher',
            'profile_pic' => $validated['profile_pic'] ?? '',
            'phone' => $validated['phone'],
            'email_verified_at' => now(),
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
            'bio'   => ''
        ]);

        $this->syncSubjects($user, $validated);
    }

    public function update($validated, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'profile_pic' => $validated['profile_pic'],
            'phone' => $validated['phone'],
            'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $user->password,
            'status' => $validated['status'],
        ]);

        $this->syncSubjects($user, $validated);
    }

    protected function syncSubjects($user, $validated)
    {
        $subjects = $validated['subjects'] ?? [];
        $fees = $validated['fees'] ?? [];

        TeacherSubject::where('teacher_id', $user->id)->delete();

        if (empty($subjects) || empty($fees)) return;

        $rows = collect($subjects)
            ->zip($fees)
            ->filter(fn($pair) => $pair[0] && $pair[1])
            ->map(fn($pair) => [
                'teacher_id' => $user->id,
                'subject_id' => $pair[0],
                'session_fee' => $pair[1],
                'is_active' => 1,
            ])->toArray();

        if (!empty($rows)) {
            TeacherSubject::insert($rows);
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.teacher.index')->with('message', [
            'status' => 'success',
            'msg' => 'Teacher Deleted Successfully'
        ]); 
    }

    public function fees($id)
    {
        $subjects = Subject::where('status', 'active')->get();
        $session_fees = TeacherSubject::where('teacher_id', $id)->get();
        return view('admin.components.fees-model', compact('subjects', 'session_fees'))->render();
    }
}
