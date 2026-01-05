@foreach ($session_fees as $fees)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Subject</label>
            <select name="subject[]" id="subject" class="form-control">
                <option value="">Select Subject</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id ?? '' }}" {{ $fees->subject_id === $subject->id ? 'selected' : '' }}>{{ $subject->name ?? '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Session Fees</label>
            <input type="number" name="fees[]" id="fees" value="{{ $fees->session_fee ?? '' }}" class="form-control">
        </div>
    </div>
</div>
@endforeach
