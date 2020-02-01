@extends('layouts.app')

@section('content')
	<div class="h-12"></div>
	<div class="flex-1 relative w-full h-full">
		<div class="absolute overflow-y-auto w-full">
			<h1 class="section suggestions_section font-bold text-lg relative shadow w-full md:w-170 mx-auto p-4 mb-2">
				Sugestii/Pareri:
			</h1>
			@foreach ($data['suggestions'] as $suggestion)
				<section class="section suggestions_section relative shadow w-full md:w-170 mx-auto p-4 text-justify hover:nested-hidden-show">
					@can('delete', $suggestion)
					<form class="hidden" action="{{route('sugestii.destroy', ['sugestii'=>$suggestion->id])}}" method="post">
						@csrf
						@method('delete')
						@buttonDelete(['class'=>'float-right text-xs'])
						@endbuttonDelete
					</form>
					@endcan
					<h1 class="font-semibold underline">
						{{$suggestion->author}}
					</h1>
					{{$suggestion->text}}
				</section>
			@endforeach
			
			<form class="section suggestions_section relative shadow w-full md:w-170 mt-8 mx-auto p-4 mb-2"
			acton="/sugestii" method="POST">
				<h1 class="font-bold text-lg">
					Adauga o sugestie:
				</h1>
				@csrf
				@formgroup(['class'=>'relative w-1/2 z-30', 'required'=>'true',
					'label' => ['value'=>'Nume autor:', 'class'=>'w-full font-bold'],
					'input' => ['value'=>old('author'), 'id'=>'author', 'name'=>'author'],
					'iErrors' => $errors->get('author')
				])
				@endformgroup
				<hr>
				@formgrouptextarea(['class'=>'relative w-full', 'required'=>'true',
					'label' => ['value'=>'Sugestie/Parere:', 'class'=>'w-full font-bold'],
					'input' => ['value'=>old('text'), 'id'=>'text', 'name'=>'text'],
					'iErrors' => $errors->get('text')
				])
				@endformgrouptextarea
				<hr>
				<button class="relative float-right adminAddBtn">
					Adauga
				</button>
				<div style="clear:both"></div>
			</form>
		</div>
	</div>
@stop