@php
	$verses_preview = \Session::get('verses_preview');
	$form_fields = ['index' => 'Index capitol', 'text' => 'Denumire capitol:'];
	$value; $iErrors;
	
@endphp

<div class="m-5">
	<strong>Adauga un capitol:</strong>
	
	@if( $verses_preview )
		<div id="preview-output" class="bg-light">
			@foreach( $verses_preview as $index => $verse )
				<p class="list-group-item-action m-0"> {{ $index + 1 .'. '. $verse }} </p>
			@endforeach
		</div>
	@endif
	
	<form class="form-prevent-multiple-submits" 
	action="{{route('traduceri.carti.capitole.store', ['traducere' => request('version'), 'carte' => request('book')])}}" method="POST">
		@csrf
		<input type="hidden" name="submited" value="create_chapter">
		
		@foreach( $form_fields as $name => $label )
			@formgroup(['class'=>'w-full', 'required'=>'true',
				'label' => ['value'=>$label, 'class'=>'w-full'],
				'input' => ['id'=>$name.'_', 'name'=>$name, 'value'=>old('submited')==='create_chapter'?old($name):''],
				'iErrors' => old('submited')==='create_chapter'?$errors->get($name):[]
			])
			@endformgroup
		@endforeach
		<br>
		<div>
			<label for="add_verses">Adauga si versete:</label>
			<input type="checkbox" name="add_verses" value="true" id="add_verses" checked>
		</div>
		
		@formgroup(['class'=>'w-full', 'required'=>'true',
			'label' => ['value'=>'Regexp:', 'class'=>'w-full'],
			'input' => ['id'=>'regexp', 'name'=>'regexp', 'value'=>old('submited')==='create_chapter'?old('regexp'):''],
			'iErrors' => old('submited')==='create_chapter'?$errors->get('regexp'):[]
		])
		@endformgroup
		
		@formgrouptextarea(['class'=>'w-full', 'required'=>'true',
			'label' => ['value'=>'Versete:', 'class'=>'w-full'],
			'input' => ['id'=>'texts', 'name'=>'texts', 'value'=>old('submited')==='create_chapter'?old('texts'):''],
			'iErrors' => old('submited')==='create_chapter'?$errors->get('texts'):[]
		])
		@endformgrouptextarea
		
		<div class="flex ml-auto">
			{{ Form::submit('preview', ['class'=>'bg-gray-400 hover:bg-gray-700 font-bold px-3 py-1 rounded', 'name'=>'submit']) }}
			{{ Form::submit('add', ['class'=>'bg-gray-900 hover:bg-gray-600 text-white font-bold px-3 py-1 rounded', 'name'=>'submit']) }}
		</div>
	</form>
</div>