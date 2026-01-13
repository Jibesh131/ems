<?php

namespace App\Services;

use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AvailabilityService
{
    public function getAll(
        array $filters = [], ?string $fromDate = null, ?string $toDate = null) {
        $query = Availability::with(['teacher', 'subject']);

        if ($fromDate || $toDate) {
            $from = $fromDate ? Carbon::parse($fromDate)->startOfDay() : Carbon::minValue();

            $to = $toDate ? Carbon::parse($toDate)->endOfDay() : Carbon::maxValue();

            $query->whereBetween('date', [$from, $to]);
        } elseif (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        if (!empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (!empty($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }

        if (!empty($filters['paid'])) {
            if ($filters['paid'] === 'paid') {
                $query->whereNotNull('payment_id');
            } elseif ($filters['paid'] === 'unpaid') {
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
