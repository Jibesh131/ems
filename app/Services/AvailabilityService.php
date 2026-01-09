<?php

namespace App\Services;

use App\Models\Availability;
use Illuminate\Support\Facades\DB;

class AvailabilityService
{
    public function getAll(array $filters = [])
    {
        $query = Availability::with(['teacher', 'subject']);

        // Date filter
        if (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        // Teacher filter
        if (!empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        // Subject filter
        if (!empty($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }

        // Payment filter
        if (!empty($filters['paid'])) {
            if ($filters['paid'] === 'paid') {
                $query->whereNotNull('payment_id');
            }

            if ($filters['paid'] === 'unpaid') {
                $query->whereNull('payment_id');
            }
        }

        return $query->get();
    }

    public function getTeacher(array $filters = [])
    {
        return Availability::query()
            ->select([
                'availabilities.id',
                'availabilities.teacher_id',
                'availabilities.subject_id',
                'availabilities.start_time',
                'availabilities.end_time',
                'users.profile_pic',
                'users.name as teacher_name',
                'teacher_subjects.session_fee',
                DB::raw('COUNT(bookings.id) as students_count'),
            ])
            ->join('users', 'users.id', '=', 'availabilities.teacher_id')
            ->join('teacher_subjects', function ($join) {
                $join->on('teacher_subjects.teacher_id', '=', 'availabilities.teacher_id')
                    ->on('teacher_subjects.subject_id', '=', 'availabilities.subject_id');
            })
            ->leftJoin('bookings', 'bookings.availability_id', '=', 'availabilities.id')
            ->when(!empty($filters['date']), function ($q) use ($filters) {
                $q->whereDate('availabilities.date', $filters['date']);
            })
            ->when(!empty($filters['subject_id']), function ($q) use ($filters) {
                $q->where('availabilities.subject_id', $filters['subject_id']);
            })
            ->groupBy(
                'availabilities.id',
                'users.name',
                'teacher_subjects.session_fee'
            )
            ->get()
            ->groupBy('teacher_id');
    }

}
