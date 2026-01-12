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
    public function index(Request $request)
    {
        $title = 'Avaliability';
        $search = false;
        $links = [];

        $availabilities = Availability::with(['subject'])->where('teacher_id', auth('web')->id())
            ->withCount('bookings')
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->when($request->date, fn($q) => $q->where('date', $request->date))
            ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
            ->get()
            ->groupBy('date');
            // TODO - Add Pagination
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
            ],
            [
                'name' => $title,
            ]
        ];
        $subjects = User::where('role', 'teacher')->with('subjects')->find(auth('web')->id())->subjects;
        return view('teacher.availability.form', compact('title', 'search', 'links', 'subjects'));
    }

    public function edit($id){
        $title = 'Edit Avaliability';
        $search = false;
        $links = [
            [
                'name' => 'Avaliability',
                'url'  => route('teacher.availability.index'),
            ],
            [
                'name' => $title,
            ]
        ];
        $availability = Availability::findOrFail($id);
        $subjects = User::where('role', 'teacher')->with('subjects')->find(auth('web')->id())->subjects;
        return view('teacher.availability.form', compact('title', 'search', 'links', 'subjects', 'availability'));
    }

    public function save(Request $request, $id = null)
    {
        $validated = $request->validate([
            'subject'    => ['required'],
            'date'       => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $teacherId = auth('web')->id();
        $date = $validated['date'];
        $startTime = $validated['start_time'];
        $endTime = $validated['end_time'];

        $excludeId = $id ?? 0;

        $overlap = Availability::where('teacher_id', $teacherId)
            ->where('date', $date)
            ->where('id', '!=', $excludeId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', [
                'status' => 'error',
                'msg'    => 'This time slot overlaps with another slot you have on the same day.'
            ])->withInput();
        }

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

            return redirect()->route('teacher.availability.index')->with('message', [
                'status' => 'success',
                'msg' => $id ? 'Availability updated successfully.' : 'Availability added successfully.',
            ]);
        } catch (Throwable $e) {
            logger()->error('Availability save failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', ['status' => 'error', 'msg' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function delete($id){
        $ava = Availability::findOrFail($id);
        $ava = $ava->delete();
        return redirect()->route('teacher.availability.index')->with('message', [
            'status' => 'success',
            'msg' => 'Availability deleted successfully',
        ]);
        // TODO - Add the delete functiona
    }

    public function getFees($id){  //Subject ID
        $teacher_id = auth('web')->id();
        $fees = TeacherSubject::where('teacher_id', $teacher_id)->where('subject_id', $id)->get();
        return $fees;
    }
}
