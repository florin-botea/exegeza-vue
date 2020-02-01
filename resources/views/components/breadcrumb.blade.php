@php
	$route = preg_split('/traduceri\/\d+/' , Request::url());
	$route = $route[1] ?? 'carti';
	$selected_version = request('version');
	$selected_book = request('book');
@endphp
<div class="m-2 px-4 py-2 flex justify-between section breadcrumb_section">
	<div class="self-center">
		<select id="selected_version">
			@if(!$selected_version)
				<option>Select version</option>
			@endif
			@foreach ($data['versions']['data'] as $version )
				@if($version->public || Auth::id() === 1)
					<option {{ $version->slug == $selected_version ? 'selected="selected"' : '' }} value="{{ '/traduceri/' . $version->slug . '/' . $route }}"> 
						{{ $version->name .' ('. $version->alias .')' }} 
					</option>
				@endif
			@endforeach
		</select>
		@if($selected_book)
		<a href="/traduceri/{{$selected_version}}/carti">
			<i class="fas fa-arrow-left"></i>
		</a>
		@endif
		<span>
			{{isset($data['chapters']) ? '/'.$data['chapters']['meta']['book']['name'] : ''}}
			{{request('chapter') ? '/capitolul '.request('chapter') : ''}}
		</span>
	</div>
	@can('create', App\Bible::class)
		<div class="p-2">
			@include('components.buttons.buttonToggleEdit')
		</div>
	@endcan
</div>