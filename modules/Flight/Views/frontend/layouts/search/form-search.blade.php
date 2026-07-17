<form action="{{ route("flight.search") }}" class="form bravo_form goibibo-flight-form" method="get">
    <style>
        .goibibo-flight-form {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }
        .trip-type-toggles {
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
        }
        .trip-type-toggles label {
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            color: #4a4a4a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .trip-type-toggles input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #ff5f1f;
            cursor: pointer;
        }
        .search-bar-unified {
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            background: #fff;
            align-items: center;
            position: relative;
        }
        .search-field {
            flex: 1;
            padding: 12px 15px;
            border-right: 1px solid #e0e0e0;
            position: relative;
            cursor: pointer;
            min-width: 0;
        }
        .search-field:last-child {
            border-right: none;
            padding: 0;
            flex: 0 0 auto;
        }
        .search-field:hover {
            background-color: #fcfcfc;
        }
        .search-field label {
            display: block;
            font-size: 13px;
            color: #777;
            margin-bottom: 4px;
            font-weight: 500;
            cursor: pointer;
        }
        .search-field input, .search-field .mock-input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 24px;
            font-weight: 800;
            color: #141823;
            outline: none;
            cursor: pointer;
            padding: 0;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        .search-field input::placeholder {
            color: #ccc;
        }
        .search-field .sub-text {
            font-size: 13px;
            color: #777;
            margin-top: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .btn-search-flight {
            background: linear-gradient(135deg, #ff5f1f, #ff8c00);
            color: #fff;
            border: none;
            font-size: 22px;
            font-weight: 800;
            padding: 0 40px;
            height: 100%;
            min-height: 85px;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        .btn-search-flight:hover {
            opacity: 0.9;
        }
        
        /* Autocomplete Dropdown */
        .tp-autocomplete-dropdown {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            width: 350px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }
        .tp-dropdown-item {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }
        .tp-dropdown-item:hover {
            background: #f7f9fc;
        }
        .tp-dropdown-item .icon {
            font-size: 20px;
            color: #999;
            margin-right: 15px;
        }
        .tp-dropdown-item .details {
            flex: 1;
        }
        .tp-dropdown-item .city {
            font-size: 15px;
            font-weight: 700;
            color: #333;
        }
        .tp-dropdown-item .airport {
            font-size: 12px;
            color: #777;
        }
        .tp-dropdown-item .iata {
            font-size: 14px;
            font-weight: 700;
            color: #ff5f1f;
        }

        /* Traveler Dropdown */
        .traveler-dropdown {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            width: 300px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            padding: 20px;
        }
        .traveler-dropdown.active {
            display: block;
        }
        .t-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .t-row:last-child {
            margin-bottom: 0;
        }
        .t-label strong {
            display: block;
            font-size: 15px;
            color: #333;
        }
        .t-label span {
            font-size: 12px;
            color: #888;
        }
        .t-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .t-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ff5f1f;
            background: #fff;
            color: #ff5f1f;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }
        .t-btn:hover {
            background: #ff5f1f;
            color: #fff;
        }
        .t-count {
            font-size: 16px;
            font-weight: 700;
            width: 15px;
            text-align: center;
        }

        /* Swap Button */
        .swap-btn {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 36px;
            height: 36px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff5f1f;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 10;
        }
        .swap-btn:hover {
            background: #f7f9fc;
        }
        
        .date-mock-input {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }
        .date-mock-input span.day {
            font-size: 28px;
            font-weight: 900;
            color: #141823;
        }
        .date-mock-input span.month-year {
            font-size: 14px;
            font-weight: 500;
            color: #141823;
        }
        
        @media (max-width: 991px) {
            .search-bar-unified {
                flex-direction: column;
                border: none;
                background: transparent;
            }
            .search-field {
                border: 1px solid #e0e0e0;
                border-radius: 12px;
                margin-bottom: 10px;
                background: #fff;
                width: 100%;
            }
            .btn-search-flight {
                border-radius: 12px;
                width: 100%;
                margin-top: 10px;
            }
            .swap-btn {
                transform: translate(-50%, -50%) rotate(90deg);
                top: 100%;
                left: 50%;
            }
        }
    </style>

    <div class="g-field-search">
        <!-- Trip Type Toggles -->
        <div class="trip-type-toggles">
            <label>
                <input type="radio" name="trip_type" value="oneway" checked onchange="toggleRoundTrip(this)"> One-way
            </label>
            <label>
                <input type="radio" name="trip_type" value="roundtrip" onchange="toggleRoundTrip(this)"> Round-trip
            </label>
        </div>

        <div class="search-bar-unified">
            <!-- FROM -->
            <div class="search-field" id="field-from" onclick="focusInput('input-from')">
                <label>From</label>
                <input type="text" id="input-from" placeholder="Enter City or Airport" autocomplete="off" onkeyup="searchAirport(this.value, 'from')">
                <input type="hidden" id="location_id" name="location_id" value="{{ request('location_id') }}">
                <div class="sub-text" id="sub-from">[Select Airport]</div>
                <div class="tp-autocomplete-dropdown" id="dropdown-from"></div>
                <div class="swap-btn" onclick="event.stopPropagation(); swapLocations();">
                    <i class="fa fa-exchange"></i>
                </div>
            </div>

            <!-- TO -->
            <div class="search-field" id="field-to" onclick="focusInput('input-to')">
                <label>To</label>
                <input type="text" id="input-to" placeholder="Enter City or Airport" autocomplete="off" onkeyup="searchAirport(this.value, 'to')">
                <input type="hidden" id="destination_id" name="destination_id" value="{{ request('destination_id') }}">
                <div class="sub-text" id="sub-to">[Select Airport]</div>
                <div class="tp-autocomplete-dropdown" id="dropdown-to"></div>
            </div>

            <!-- DEPART DATE -->
            <div class="search-field date-field" id="field-depart">
                <label>Depart <i class="fa fa-chevron-down ml-1"></i></label>
                <input type="text" name="start" id="depart-date-input" class="d-none" value="{{ request('start', date('Y-m-d')) }}">
                <div class="date-mock-input">
                    <span class="day" id="depart-day">{{ date('d') }}</span>
                    <span class="month-year" id="depart-month-year">{{ date('M y') }}</span>
                </div>
                <div class="sub-text" id="depart-weekday">{{ date('l') }}</div>
            </div>

            <!-- RETURN DATE -->
            <div class="search-field date-field" id="field-return" style="opacity: 0.5;">
                <label>Return <i class="fa fa-chevron-down ml-1"></i></label>
                <input type="text" name="end" id="return-date-input" class="d-none" value="{{ request('end') }}" disabled>
                <div class="date-mock-input">
                    <span class="day" id="return-day">Tap</span>
                    <span class="month-year" id="return-month-year">to add</span>
                </div>
                <div class="sub-text" id="return-weekday">Return Date</div>
            </div>

            <!-- TRAVELERS & CLASS -->
            <div class="search-field" id="field-travelers" onclick="toggleTravelerDropdown()">
                <label>Travelers & Class <i class="fa fa-chevron-down ml-1"></i></label>
                <div class="mock-input"><span id="total-travelers">1</span> Traveler</div>
                <div class="sub-text" id="class-summary">Economy</div>
                
                <div class="traveler-dropdown" id="traveler-dropdown" onclick="event.stopPropagation();">
                    <div class="t-row">
                        <div class="t-label">
                            <strong>Economy</strong>
                        </div>
                        <div class="t-controls">
                            <div class="t-btn" onclick="updateSeatCount('seat_economy', -1)">-</div>
                            <div class="t-count" id="count-seat_economy">1</div>
                            <div class="t-btn" onclick="updateSeatCount('seat_economy', 1)">+</div>
                            <input type="hidden" name="seat_type[economy]" id="input-seat_economy" value="1">
                        </div>
                    </div>
                    <div class="t-row">
                        <div class="t-label">
                            <strong>Premium</strong>
                        </div>
                        <div class="t-controls">
                            <div class="t-btn" onclick="updateSeatCount('seat_premium', -1)">-</div>
                            <div class="t-count" id="count-seat_premium">0</div>
                            <div class="t-btn" onclick="updateSeatCount('seat_premium', 1)">+</div>
                            <input type="hidden" name="seat_type[premium]" id="input-seat_premium" value="0">
                        </div>
                    </div>
                    <div class="t-row">
                        <div class="t-label">
                            <strong>VIP</strong>
                        </div>
                        <div class="t-controls">
                            <div class="t-btn" onclick="updateSeatCount('seat_vip', -1)">-</div>
                            <div class="t-count" id="count-seat_vip">0</div>
                            <div class="t-btn" onclick="updateSeatCount('seat_vip', 1)">+</div>
                            <input type="hidden" name="seat_type[vip]" id="input-seat_vip" value="0">
                        </div>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="button" class="btn btn-primary btn-sm" onclick="toggleTravelerDropdown()">Done</button>
                    </div>
                </div>
            </div>

            <!-- SUBMIT -->
            <div class="search-field">
                <button class="btn-search-flight" type="submit">{{__("Search")}}</button>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    // Travelpayouts Autocomplete API
    let tpDebounceTimer;
    function searchAirport(query, target) {
        clearTimeout(tpDebounceTimer);
        const dropdown = document.getElementById(`dropdown-${target}`);
        
        if(query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        tpDebounceTimer = setTimeout(() => {
            fetch(`https://autocomplete.travelpayouts.com/places2?term=${query}&locale=en&types[]=airport&types[]=city`)
                .then(response => response.json())
                .then(data => {
                    dropdown.innerHTML = '';
                    if(data.length > 0) {
                        data.forEach(place => {
                            // Extract properties properly
                            let name = place.name;
                            let code = place.code;
                            let country = place.country_name || '';
                            let type = place.type; // city or airport
                            
                            if (type === 'airport' || type === 'city') {
                                let item = document.createElement('div');
                                item.className = 'tp-dropdown-item';
                                item.onclick = () => selectAirport(target, name, code, country);
                                
                                let icon = type === 'airport' ? 'fa-plane' : 'fa-building';
                                
                                item.innerHTML = `
                                    <div class="icon"><i class="fa ${icon}"></i></div>
                                    <div class="details">
                                        <div class="city">${name}</div>
                                        <div class="airport">${country}</div>
                                    </div>
                                    <div class="iata">${code}</div>
                                `;
                                dropdown.appendChild(item);
                            }
                        });
                        dropdown.style.display = 'block';
                    } else {
                        dropdown.style.display = 'none';
                    }
                });
        }, 300);
    }

    function selectAirport(target, name, code, country) {
        document.getElementById(`input-${target}`).value = `${name} (${code})`;
        document.getElementById(`sub-${target}`).innerText = country;
        
        // Ensure hidden input exists for booking-core search map
        if(target === 'from') {
            document.getElementById('location_id').value = code;
        } else {
            document.getElementById('destination_id').value = code;
        }
        
        document.getElementById(`dropdown-${target}`).style.display = 'none';
    }

    // Hide dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if(!document.getElementById('field-from').contains(e.target)) {
            document.getElementById('dropdown-from').style.display = 'none';
        }
        if(!document.getElementById('field-to').contains(e.target)) {
            document.getElementById('dropdown-to').style.display = 'none';
        }
        if(!document.getElementById('field-travelers').contains(e.target)) {
            document.getElementById('traveler-dropdown').classList.remove('active');
        }
    });

    function focusInput(id) {
        document.getElementById(id).focus();
    }

    function swapLocations() {
        let fromInput = document.getElementById('input-from').value;
        let fromSub = document.getElementById('sub-from').innerText;
        let fromCode = document.getElementById('location_id').value;
        
        let toInput = document.getElementById('input-to').value;
        let toSub = document.getElementById('sub-to').innerText;
        let toCode = document.getElementById('destination_id').value;

        document.getElementById('input-from').value = toInput;
        document.getElementById('sub-from').innerText = toSub;
        document.getElementById('location_id').value = toCode;

        document.getElementById('input-to').value = fromInput;
        document.getElementById('sub-to').innerText = fromSub;
        document.getElementById('destination_id').value = fromCode;
    }

    // Traveler Dropdown
    function toggleTravelerDropdown() {
        document.getElementById('traveler-dropdown').classList.toggle('active');
    }

    function updateSeatCount(type, change) {
        let countEl = document.getElementById(`count-${type}`);
        let inputEl = document.getElementById(`input-${type}`);
        let current = parseInt(countEl.innerText);
        let newVal = current + change;
        
        if(newVal < 0) return;
        
        // Ensure at least 1 passenger total
        if(change === -1) {
            let eco = parseInt(document.getElementById('count-seat_economy').innerText);
            let prem = parseInt(document.getElementById('count-seat_premium').innerText);
            let vip = parseInt(document.getElementById('count-seat_vip').innerText);
            if((eco + prem + vip) <= 1) return;
        }

        countEl.innerText = newVal;
        inputEl.value = newVal;

        updateTravelerSummary();
    }

    function updateTravelerSummary() {
        let eco = parseInt(document.getElementById('count-seat_economy').innerText);
        let prem = parseInt(document.getElementById('count-seat_premium').innerText);
        let vip = parseInt(document.getElementById('count-seat_vip').innerText);
        let total = eco + prem + vip;
        
        document.getElementById('total-travelers').innerText = total;

        let primaryClass = 'Economy';
        if(vip > 0) primaryClass = 'VIP';
        else if (prem > 0) primaryClass = 'Premium';
        
        document.getElementById('class-summary').innerText = primaryClass;
    }

    // Date Picker Logic
    function toggleRoundTrip(radio) {
        let returnField = document.getElementById('field-return');
        let returnInput = document.getElementById('return-date-input');
        if(radio.value === 'roundtrip') {
            returnField.style.opacity = '1';
            returnInput.disabled = false;
            
            // Auto open datepicker
            $('#field-return').trigger('click');
        } else {
            returnField.style.opacity = '0.5';
            returnInput.disabled = true;
            document.getElementById('return-day').innerText = 'Tap';
            document.getElementById('return-month-year').innerText = 'to add';
            document.getElementById('return-weekday').innerText = 'Return Date';
        }
    }

    // Init Datepicker
    $(function() {
        let today = moment();
        let departDate = moment();
        let returnDate = moment().add(7, 'days');

        function updateDateUI(dateObj, target) {
            document.getElementById(`${target}-day`).innerText = dateObj.format('DD');
            document.getElementById(`${target}-month-year`).innerText = dateObj.format('MMM YY');
            document.getElementById(`${target}-weekday`).innerText = dateObj.format('dddd');
            document.getElementById(`${target}-date-input`).value = dateObj.format('YYYY-MM-DD');
        }

        // Initialize Depart
        updateDateUI(departDate, 'depart');

        $('#field-depart').daterangepicker({
            singleDatePicker: true,
            minDate: today,
            autoApply: true
        }, function(start, end, label) {
            departDate = start;
            updateDateUI(departDate, 'depart');
            
            // If return date is before new depart date, update it
            if(!document.getElementById('return-date-input').disabled && returnDate.isBefore(departDate)) {
                returnDate = moment(departDate).add(1, 'days');
                updateDateUI(returnDate, 'return');
            }
        });

        $('#field-return').daterangepicker({
            singleDatePicker: true,
            minDate: today,
            autoApply: true
        }, function(start, end, label) {
            returnDate = start;
            updateDateUI(returnDate, 'return');
            
            // Auto switch to roundtrip
            let radios = document.getElementsByName('trip_type');
            for(let i=0; i<radios.length; i++) {
                if(radios[i].value === 'roundtrip') {
                    radios[i].checked = true;
                    toggleRoundTrip(radios[i]);
                }
            }
        });
    });
</script>
