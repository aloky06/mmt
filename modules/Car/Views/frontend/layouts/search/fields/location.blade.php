<div class="form-group custom-location-group" id="car-location-wrapper" onclick="document.getElementById('car-location-input').focus()">
    <i class="field-icon fa icofont-map"></i>
    <div class="form-content" style="position:relative;">
        <label> {{ $field['title'] ?? 'Location' }} </label>
        
        <!-- Visible Input -->
        <?php
        $location_name = "";
        $list_json = [];
        $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json , &$location_name) {
            foreach ($locations as $location) {
                $translate = $location->translateOrOrigin(app()->getLocale());
                if (Request::query('location_id') == $location->id){
                    $location_name = $translate->name;
                }
                $list_json[] = [
                    'id' => $location->id,
                    'title' => $prefix . ' ' . $translate->name,
                ];
                $traverse($location->children, $prefix . '-');
            }
        };
        $traverse($list_location ?? \Modules\Location\Models\Location::where('status', 'publish')->get()->toTree());
        ?>
        
        <input type="text" id="car-location-input" placeholder="{{__("Where are you going?")}}" autocomplete="off" onkeyup="searchCarLocation(this.value)" onclick="searchCarLocation(this.value)" value="{{ $location_name }}">
        
        <!-- Hidden Inputs for Form Submission -->
        <input type="hidden" name="location_id" id="car-location_id" value="{{request()->input('location_id')}}">
        <input type="hidden" name="map_place" id="car_map_place" value="{{request()->input('map_place')}}">
        <input type="hidden" name="map_lat" id="car_map_lat" value="{{request()->input('map_lat')}}">
        <input type="hidden" name="map_lgn" id="car_map_lgn" value="{{request()->input('map_lgn')}}">

        <!-- Dropdown Container -->
        <div class="premium-autocomplete-dropdown" id="car-location-dropdown"></div>
    </div>
</div>

<style>
/* Reset form group to allow absolute positioning */
.custom-location-group {
    position: relative;
    cursor: pointer;
}
#car-location-input {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 20px;
    font-weight: 800;
    color: #1a1a2e;
    outline: none;
    padding: 0;
    margin-top: 2px;
}
#car-location-input::placeholder {
    color: #ccc;
    font-weight: 600;
}
.premium-autocomplete-dropdown {
    position: absolute;
    top: calc(100% + 15px);
    left: -15px;
    width: calc(100% + 30px);
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    z-index: 100000;
    display: none;
    max-height: 320px;
    overflow-y: auto;
    padding: 10px 0;
}
.prem-dropdown-item {
    padding: 14px 20px;
    cursor: pointer;
    border-bottom: 1px solid #f5f5f5;
    display: flex;
    align-items: center;
    transition: background 0.2s;
}
.prem-dropdown-item:last-child {
    border-bottom: none;
}
.prem-dropdown-item:hover {
    background: #fff5f0;
}
.prem-dropdown-item .icon {
    width: 38px;
    height: 38px;
    background: #fff0ea;
    color: #ff5f1f;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    margin-right: 15px;
}
.prem-dropdown-item .details {
    flex: 1;
}
.prem-dropdown-item .city {
    font-size: 15px;
    font-weight: 700;
    color: #333;
    line-height: 1.2;
    text-align: left;
}
.prem-dropdown-item .country {
    font-size: 12px;
    color: #888;
    margin-top: 4px;
    text-align: left;
}
.prem-dropdown-loading {
    padding: 20px;
    text-align: center;
    color: #999;
    font-size: 14px;
}
</style>

<script>
    // Prefetch all locations into an array for lightning fast local search
    let carAllLocations = {!! json_encode($list_json) !!};
    
    function searchCarLocation(query) {
        const dropdown = document.getElementById('car-location-dropdown');
        dropdown.innerHTML = '';
        
        let q = query.toLowerCase().trim();
        let matches = [];
        
        if (q.length === 0) {
            matches = carAllLocations;
        } else {
            matches = carAllLocations.filter(loc => loc.title.toLowerCase().includes(q));
        }

        if(matches.length > 0) {
            matches.forEach(place => {
                let item = document.createElement('div');
                item.className = 'prem-dropdown-item';
                item.onclick = function(e) {
                    e.stopPropagation();
                    selectCarLocation(place.id, place.title.replace(/-/g, '').trim());
                };
                
                // Clean up prefixes like '- '
                let cleanTitle = place.title.replace(/-/g, '').trim();

                item.innerHTML = `
                    <div class="icon"><i class="fa fa-map-marker"></i></div>
                    <div class="details">
                        <div class="city">${cleanTitle}</div>
                        <div class="country">City / Location</div>
                    </div>
                `;
                dropdown.appendChild(item);
            });
            dropdown.style.display = 'block';
        } else {
            dropdown.innerHTML = '<div class="prem-dropdown-loading">No locations found.</div>';
            dropdown.style.display = 'block';
        }
    }

    function selectCarLocation(id, title) {
        document.getElementById('car-location-input').value = title;
        document.getElementById('car-location_id').value = id;
        document.getElementById('car-location-dropdown').style.display = 'none';
    }

    // Hide dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        let wrapper = document.getElementById('car-location-wrapper');
        let dropdown = document.getElementById('car-location-dropdown');
        if (wrapper && dropdown && !wrapper.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>