@php $date_id = 'flatpickr_'.uniqid(); @endphp
<div class="form-group">
    <i class="field-icon icofont-wall-clock"></i>
    <div class="form-content">
        <div class="premium-date-search" id="{{ $date_id }}" style="cursor: pointer;">
            <div class="date-wrapper">
                <div class="check-in-wrapper">
                    <label>{{ $field['title'] ?? 'Date' }}</label>
                    <div class="date-displays" style="display: flex; align-items: center; gap: 5px; font-weight: 700; font-size: 16px; color: #1a2b49; white-space: nowrap;">
                        <div class="render check-in-render" id="{{ $date_id }}_start">{{Request::query('start',display_date(strtotime("today")))}}</div>
                        <span> - </span>
                        <div class="render check-out-render" id="{{ $date_id }}_end">{{Request::query('end',display_date(strtotime("+1 day")))}}</div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="check-in-input" id="{{ $date_id }}_start_input" value="{{Request::query('start',date("Y-m-d"))}}" name="start">
            <input type="hidden" class="check-out-input" id="{{ $date_id }}_end_input" value="{{Request::query('end',date("Y-m-d",strtotime("+1 day")))}}" name="end">
            <input type="hidden" class="premium-date-input" id="{{ $date_id }}_range_input" name="date" value="{{Request::query('date',date("Y-m-d")." - ".date("Y-m-d",strtotime("+1 day")))}}">
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Premium Orange Theme for Flatpickr */
    .flatpickr-calendar.arrowTop:before { border-bottom-color: #ff5f1f !important; }
    .flatpickr-calendar.arrowTop:after { border-bottom-color: #ff5f1f !important; }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
        background: #ff5f1f !important;
        border-color: #ff5f1f !important;
    }
    .flatpickr-day.inRange { box-shadow: -5px 0 0 #fff0ea, 5px 0 0 #fff0ea !important; background: #fff0ea !important; border-color: #fff0ea !important; }
    .flatpickr-day:hover { background: #fff0ea !important; border-color: #fff0ea !important; color: #1a1a2e !important; }
    .flatpickr-months .flatpickr-month { background: #ff5f1f !important; color: #fff !important; fill: #fff !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months { background: #ff5f1f !important; color: #fff !important; }
    .flatpickr-current-month .numInputWrapper span.arrowUp:after { border-bottom-color: #fff !important; }
    .flatpickr-current-month .numInputWrapper span.arrowDown:after { border-top-color: #fff !important; }
    .flatpickr-weekdays { background: #ff5f1f !important; }
    span.flatpickr-weekday { color: #fff !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#{{ $date_id }}", {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        defaultDate: [
            document.getElementById('{{ $date_id }}_start_input').value,
            document.getElementById('{{ $date_id }}_end_input').value
        ],
        onChange: function(selectedDates, dateStr, instance) {
            if(selectedDates.length === 2) {
                // Formatting for display like '12 Aug, 2026'
                const startStr = selectedDates[0].toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                const endStr = selectedDates[1].toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
                const startDb = instance.formatDate(selectedDates[0], "Y-m-d");
                const endDb = instance.formatDate(selectedDates[1], "Y-m-d");

                document.getElementById('{{ $date_id }}_start').textContent = startStr;
                document.getElementById('{{ $date_id }}_end').textContent = endStr;
                document.getElementById('{{ $date_id }}_start_input').value = startDb;
                document.getElementById('{{ $date_id }}_end_input').value = endDb;
                document.getElementById('{{ $date_id }}_range_input').value = startDb + " - " + endDb;
            }
        }
    });
    
    // Initial format on load
    const startInitial = new Date(document.getElementById('{{ $date_id }}_start_input').value);
    const endInitial = new Date(document.getElementById('{{ $date_id }}_end_input').value);
    if (!isNaN(startInitial) && !isNaN(endInitial)) {
        document.getElementById('{{ $date_id }}_start').textContent = startInitial.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
        document.getElementById('{{ $date_id }}_end').textContent = endInitial.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }
});
</script>