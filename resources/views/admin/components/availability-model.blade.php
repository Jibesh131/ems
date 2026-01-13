<!-- Week Navigation -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="mb-0">
        Week of {{ $startDate->format('F j') }} - {{ $endDate->format('j, Y') }}
    </h6>
</div>

{{-- <button class="btn btn-outline-secondary btn-sm">&laquo; Previous Week</button> --}}
{{-- <button class="btn btn-outline-secondary btn-sm">Next Week &raquo;</button> --}}

<!-- Availability Schedule -->
<div class="accordion" id="availabilityAccordion">
    @foreach (Carbon\CarbonPeriod::create($startDate, $endDate) as $date)
        @php
            $dateKey = $date->toDateString();
            $dayAvailabilities = $weeklyData[$dateKey] ?? collect();

            $isToday = $date->isToday();
        @endphp

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button {{ !$isToday ? 'collapsed' : '' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#day-{{ $date->format('Ymd') }}">
                    <strong>{{ $date->format('l, F j') }}</strong>
                </button>
            </h2>

            <div id="day-{{ $date->format('Ymd') }}" class="accordion-collapse collapse {{ $isToday ? 'show' : '' }}"
                data-bs-parent="#availabilityAccordion">
                <div class="accordion-body">
                    <div class="d-flex flex-wrap">

                        @forelse ($dayAvailabilities as $slot)
                            <span class="time-slot {{ $slot->booking_id ? 'booked' : 'available' }}">
                                <span class="time text-bold ">{{ format_date($slot->start_time, 'g:i A') . ' - ' . format_date($slot->end_time, 'g:i A')}}</span>
                                <span class="subject d-block">Subject-4</span>
                            </span>
                        @empty
                            <span class="text-muted text-center w-100">No availability</span>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
