<div class="form-group custom-location-group" id="event-location-wrapper" onclick="document.getElementById('event-location-input').focus()">
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
        
        <input type="text" id="event-location-input" placeholder="{{__("Where are you going?")}}" autocomplete="off" onkeyup="searchEventLocation(this.value)" onclick="searchEventLocation(this.value)" value="{{ request()->input('map_place') ?? $location_name }}">
        
        <!-- Hidden Inputs for Form Submission -->
        <input type="hidden" name="location_id" id="event_location_id" value="{{request()->input('location_id')}}">
        <input type="hidden" name="map_place" id="event_map_place" value="{{request()->input('map_place')}}">
        <input type="hidden" name="map_lat" id="event_map_lat" value="{{request()->input('map_lat')}}">
        <input type="hidden" name="map_lgn" id="event_map_lgn" value="{{request()->input('map_lgn')}}">

        <!-- Dropdown Container -->
        <div class="premium-autocomplete-dropdown" id="event-location-dropdown"></div>
    </div>
</div>

<style>
/* Reset form group to allow absolute positioning */
.custom-location-group {
    position: relative;
    cursor: pointer;
}
#event-location-input {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    outline: none;
    padding: 0;
    margin-top: 2px;
}
#event-location-input::placeholder {
    color: #ccc;
    font-weight: 600;
}
.premium-autocomplete-dropdown {
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    z-index: 100000;
    display: none;
    max-height: 320px;
    overflow-y: auto;
    padding: 10px 0;
    font-family: 'Inter', 'Poppins', sans-serif;
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
    // Debounce function to limit API calls
    function debounceEvent(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Fetch user country on load
    window.userCountry = window.userCountry || '';
    if(!window.userCountry) {
        fetch('https://get.geojs.io/v1/ip/geo.json')
            .then(res => res.json())
            .then(data => { if(data.country) window.userCountry = data.country; })
            .catch(e => console.log('Could not fetch user country'));
    }

    // Fetch from Photon API (Free OSM)
    const searchEventLocation = debounceEvent(async function(query) {
        const dropdown = document.getElementById('event-location-dropdown');
        dropdown.innerHTML = '';
        
        let q = query.trim();
        
        if (q.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        dropdown.innerHTML = '<div class="prem-dropdown-loading">Searching...</div>';
        dropdown.style.display = 'block';

        // Append user country to bias results
        let finalQuery = q;
        if (window.userCountry) finalQuery += ' ' + window.userCountry;

        try {
            // Photon API endpoint (OpenStreetMap) - No API key required
            let res = await fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(finalQuery)}&limit=5`);
            let data = await res.json();
            
            dropdown.innerHTML = '';

            if (data.features && data.features.length > 0) {
                data.features.forEach(feature => {
                    let prop = feature.properties;
                    let geom = feature.geometry.coordinates; // [lng, lat]
                    
                    let name = prop.name;
                    let subtitle = [];
                    if(prop.city && prop.city !== name) subtitle.push(prop.city);
                    if(prop.state) subtitle.push(prop.state);
                    if(prop.country) subtitle.push(prop.country);
                    
                    let subText = subtitle.join(', ');

                    let item = document.createElement('div');
                    item.className = 'prem-dropdown-item';
                    item.onclick = function(e) {
                        e.stopPropagation();
                        // geom[1] = lat, geom[0] = lng
                        selectEventLocation(name, geom[1], geom[0], subText);
                    };

                    item.innerHTML = `
                        <div class="icon"><i class="fa fa-map-marker"></i></div>
                        <div class="details">
                            <div class="city">${name}</div>
                            <div class="country">${subText || 'Location'}</div>
                        </div>
                    `;
                    dropdown.appendChild(item);
                });
            } else {
                dropdown.innerHTML = '<div class="prem-dropdown-loading">No locations found.</div>';
            }
        } catch(e) {
            dropdown.innerHTML = '<div class="prem-dropdown-loading">Error loading results.</div>';
        }
    }, 400);

    function selectEventLocation(name, lat, lng, subtitle) {
        document.getElementById('event-location-input').value = name;
        document.getElementById('event_map_place').value = name;
        document.getElementById('event_map_lat').value = lat;
        document.getElementById('event_map_lgn').value = lng;
        document.getElementById('event-location-dropdown').style.display = 'none';
    }

    // Hide dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        let wrapper = document.getElementById('event-location-wrapper');
        let dropdown = document.getElementById('event-location-dropdown');
        if (wrapper && dropdown && !wrapper.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>