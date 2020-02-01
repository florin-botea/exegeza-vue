@extends('layouts.chapters_verses')

@php
	$version = request('version');
	$book = request('book');
	$chapter = request('chapter');
	$verses_preview = \Session::get('verses_preview');
@endphp

@section('_content')
<div class="py-2" id="books_chapters">
	<div class="mt-3" id="chapter_content">
		@can('create', App\Chapter::class)
			@include('forms.verses_add')
		@endcan
	
		<div style="list-style-type:none;padding:1px;margin:0px;">
			@if( $verses_preview )
				<div id="preview-output" class="bg-light">
					@foreach( $verses_preview as $index => $verse )
						<p class="list-group-item-action m-0"> {{ $index + 1 .'. '. $verse }} </p>
					@endforeach
				</div>
				@else 
				<the-verse-section class="m-2 p-2 section verses_section"></the-verse-section>
			@endif
		</div>
	</div>
</div>
@endsection