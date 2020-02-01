@php
	$form_fields = ['index' => 'Index capitol', 'text' => 'Denumire capitol:'];
@endphp

@if(request('edit'))
<div class="p-4 m-2 section chapter_form">
	<strong>Editeaza un capitol:</strong>

	@foreach ($data['chapters']['data'] as $chapter)
		<div class="relative">
			<form class="form-prevent-multiple-submits" 
			action="{{route('traduceri.carti.capitole.update', ['traducere' => request('version'), 'carte' => request('book'), 'capitol' => $chapter->index])}}" method="POST">
				@csrf
				@method('patch')
				<input type="hidden" name="submited" value="edit_chapter_{{$chapter->id}}">
				
				@foreach( $form_fields as $name => $label )
					@formgroup(['class'=>'w-full', 'required'=>'true',
						'label' => ['value'=>$label, 'class'=>'w-full'],
						'input' => ['id'=>'book_'.$chapter->id.$name, 'name'=>$name, 'value'=>$chapter[$name]],
						'iErrors' => old('submited')==='edit_chapter_'.$chapter->id?$errors->get($name):[]
					])
					@endformgroup
				@endforeach
				
				<button type="submit" class="adminUpdateBtn btn-prevent-multiple-submits">
					Actualizeaza!
				</button>
			</form>
			<form class="form-prevent-multiple-submits" 
			action="{{route('traduceri.carti.capitole.destroy', ['traducere' => request('version'), 'carte' => request('book'), 'capitol' => $chapter->index])}}" method="POST">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
				<button type="submit" class="adminDeleteBtn absolute right-0 bottom-0 btn-prevent-multiple-submits">
					Sterge!
				</button>
			</form>
		</div>
	@endforeach
</div>
@endif