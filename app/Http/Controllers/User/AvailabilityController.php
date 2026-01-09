<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Subject;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    protected AvailabilityService $availability_service;

    public function __construct(AvailabilityService $availability_service)
    {
        $this->availability_service = $availability_service;
    }


    public function index(Request $request){
        $title = '';
        $search =  false;
        $links = [];

        $subjects = Subject::where('status', 'active')->get();
        $availabilities = $this->availability_service->getTeacher(['date' => $request->date ?? null, 'subject_id' => $request->subject ?? null]);
        return view('user.availability.index', compact('title', 'search', 'links', 'subjects', 'availabilities'));
    }
}
