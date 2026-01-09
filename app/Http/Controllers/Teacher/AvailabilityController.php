<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\TeacherSubject;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AvailabilityController extends Controller
{
    public function index()
    {
        $title = 'Avaliability';
        $search = true;
        $links = [];
        $availabilities = Availability::with('subject')->where('teacher_id', auth('web')->id())->orderBy('date')->orderBy('start_time')->get()->groupBy('date');
        $subjects = User::where('role', 'teacher')->with('subjects')->find(auth('web')->id())->subjects;
        return view('teacher.availability.index', compact('title', 'search', 'links', 'availabilities', 'subjects'));
    }

    public function add()
    {
        $title = 'Add New Avaliability';
        $search = false;
        $links = [
            [
                'name' => 'Avaliability',
                'url'  => route('teacher.availability.index'),
            ]
        ];
        $subjects = User::where('role', 'teacher')->with('subjects')->find(auth('web')->id())->subjects;
        return view('teacher.availability.form', compact('title', 'search', 'links', 'subjects'));
    }

    // public function edit(){

    // }

    public function save(Request $request, $id = null)
    {
        $validated = $request->validate([
            'subject'    => ['required'],
            'date'       => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        try {
            DB::transaction(function () use ($validated, $id) {
                if ($id) {
                    $availability = Availability::where('id', $id)->firstOrFail();

                    $availability->update([
                        'date'       => $validated['date'],
                        'subject_id' => $validated['subject'],
                        'start_time' => $validated['start_time'],
                        'end_time'   => $validated['end_time'],
                    ]);

                    return redirect()->route('admin.teacher.index')->with('message', [
                        'status' => 'success',
                        'msg' => $id ? 'Teacher updated successfully.' : 'Teacher added successfully.',
                    ]);

                } else {
                    Availability::create([
                        'teacher_id' => auth('web')->id(),
                        'date'       => $validated['date'],
                        'subject_id' => $validated['subject'],
                        'start_time' => $validated['start_time'],
                        'end_time'   => $validated['end_time'],
                    ]);
                }
            });
        } catch (Throwable $e) {
            logger()->error('Availability save failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', [ 'status' => 'error', 'msg'    => 'Something went wrong. Please try again.' ])->withInput();
        }

        return back()->with('success', ['status' => 'success', 'msg'    => 'Availability saved successfully.']);
    }
}
