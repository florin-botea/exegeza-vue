@extends('layouts.app')

@section('content')
<div class="flex relative w-full h-full">
	<verses-section-wrapper class="versesSection_wrapper w-full h-full relative md:w-1/2 overflow-y-auto">
		<div class="h-12"></div>
		@include('components.breadcrumb')
		<div class="m-2 p-2 section chapters_nav">
			<nav>
				<div class="flex flex-wrap">
					@foreach( $data['chapters']['data'] as $_chapter )
						@if( $_chapter->index == request('chapter') )
							<a class="chapters_nav_item--active px-2 shadow-lg border border-gray-400 rounded m-1" aria-current="page" title="{{ $_chapter->text }}">
								{{ $_chapter->index }}
							</a>
							@else
							<a class="chapters_nav_item hover:text-blue-500 shadow-lg border border-gray-400 font-semibold cursor-pointer px-2 rounded m-1" title="{{ $_chapter->text }}"
							href="{{route('traduceri.carti.capitole.versete.index', ['version' => request('version'), 'book' => request('book'), 'capitol' => $_chapter->index])}}">
									{{ $_chapter->index }}
							</a>
						@endif
					@endforeach
				</div>
			</nav>
			<br>
			<div class="flex">
				<button class="chapters_nav_item hover:text-blue-500 shadow-lg border border-gray-400 cursor-pointer rounded px-4" 
					onclick="location.href='{{ request('chapter') > 1 ? route('traduceri.carti.capitole.versete.index', ['version' => request('version'), 'book' => request('book'), 'capitol' => request('chapter')-1]) : route('traduceri.carti.capitole.index', ['version' => request('version'), 'book' => request('book')])}}'"
					{{ request('chapter') > 0 ? '' : 'disabled=true' }} >
					<i class="fas fa-arrow-left"></i>
				</button>
				<button class="chapters_nav_item hover:text-blue-500 shadow-lg border border-gray-400 cursor-pointer rounded px-4 ml-auto"
					onclick="location.href='{{route('traduceri.carti.capitole.versete.index', ['version' => request('version'), 'book' => request('book'), 'capitol' => request('chapter')+1])}}'"
					{{ count($data['chapters']['data']) >= request('chapter')+1 ? '' : 'disabled=true' }} >
					<i class="fas fa-arrow-right"></i>
				</button>
			</div>
		</div>
		@yield('_content')
		<comment-section-show-icon/>
	</verses-section-wrapper>
	
	<the-comment-section class="app-background w-0 md:w-1/2 absolute top-0 right-0 md:relative h-full overflow-y-auto z-30"/>
</div>
@endsection