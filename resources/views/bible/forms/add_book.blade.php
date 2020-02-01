@php
	$form_fields = ['index' => 'Index carte:', 'name' => 'Denumire carte:', 'slug' => 'Parametru in url:'];
@endphp

<div class="m-5">
	<strong>Adauga o carte:</strong>
	
	<form class="form-prevent-multiple-submits" action="{{route('traduceri.carti.store', ['traducere' => request('version')])}}" method="POST">
		@csrf
		<input type="hidden" name="submited" value="create_book">
		
		@foreach( $form_fields as $name => $label )
			@formgroup(['class'=>'w-full', 'required'=>'true',
				'label' => ['value'=>$label, 'class'=>'w-full'],
				'input' => ['id'=>$name.'_', 'name'=>$name, 'value'=>old('submited')==='create_book'?old($name):''],
				'iErrors' => old('submited')==='create_book'?$errors->get($name):[]
			])
			@endformgroup
		@endforeach

		<button type="submit" class="adminAddBtn btn-prevent-multiple-submits">
			Adauga!
		</button>
	</form>
</div>
