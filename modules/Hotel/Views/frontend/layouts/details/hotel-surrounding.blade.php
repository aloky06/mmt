@if(!empty($location_category) and !empty($translation->surrounding))
	<div class="g-surrounding bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-0 p-6 md:p-8 mb-8">
		<div class="location-title">
			<h3 class="text-2xl font-black text-gray-900 mb-6 border-b border-gray-100 pb-4 tracking-tight">{{__("What's Nearby")}}</h3>
			@foreach($location_category as $category)
				<h6 class="font-weight-bold mb-3"><i class="{{clean($category->icon_class)}} "></i> {{$category->location_category_translations->name??$category->name}}</h6>
				@if(!empty($translation->surrounding[$category->id]))
					@foreach($translation->surrounding[$category->id] as $item)
						<div class="row mb-3">
							<div class="col-lg-4">{{$item['name']}} ({{$item['value']}}{{$item['type']}})</div>
							<div class="col-lg-8">{{$item['content']}}</div>
						</div>
					@endforeach
				@endif
			@endforeach
		</div>
	</div>
	<div class="bravo-hr"></div>
@endif
