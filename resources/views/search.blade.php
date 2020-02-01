@extends('layouts.app')

@section('content')
	<div class="flex-1 flex relative w-full h-full">
		<verses-section-wrapper class="w-full h-full relative md:w-1/2 overflow-y-auto">
			<div>
				<div class="h-12"></div>
				<div class="section chapters_nav p-2 m-2">
					<nav class="py-2" aria-label="...">
						<ul class="flex flex-wrap">
							@for($i=1; $i<=$data['verses']->lastPage(); $i++)
								@if( $i == request('page', 1) )
									<a class="chapters_nav_item--active px-2 shadow-lg border border-gray-400 rounded m-1" aria-current="page">
										{{ $i }}
									</a>
									@else
									<a class="chapters_nav_item hover:text-blue-500 shadow-lg border border-gray-400 cursor-pointer px-2 rounded m-1"
									href="">
										{{ $i }}
									</a>
								@endif
							@endfor
						</ul>
					</nav>
					<div class="flex py-2">
						<button class="hover:text-blue-500 shadow-lg border border-gray-400 font-semibold cursor-pointer rounded px-4" 
							onclick="location.href='{{ $data['verses']->previousPageUrl() }}'"
							{{ $data['verses']->previousPageUrl() ? '' : 'disabled=true' }} >
							<i class="fas fa-arrow-left"></i>
						</button>
						<button class="hover:text-blue-500 shadow-lg border border-gray-400 font-semibold cursor-pointer rounded px-4 ml-auto"
							onclick="location.href='{{ $data['verses']->nextPageUrl() }}'"
							{{ $data['verses']->nextPageUrl() ? '' : 'disabled=true' }} >
							<i class="fas fa-arrow-right"></i>
						</button>
					</div>
				</div>
			
				<verses-with-sending class="p-2 m-2 section verses_section"></verses-with-sending>
			</div>
		</verses-section-wrapper>
		
		<the-comment-section class="w-0 md:w-1/2 absolute right-0 md:relative h-full bg-yellow-100 overflow-y-auto z-30"/>
	</div>
@stop