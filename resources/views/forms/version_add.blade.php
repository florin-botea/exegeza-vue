@php
	$form_fields = ['name' => 'Denumire versiune:', 'alias' => 'Alias versiune:', 'slug' => 'Parametru in url:'];
@endphp

<div class="p-4 m-2 form bible_form">
	<strong>Adauga o versiune:</strong>
	<form class="form-prevent-multiple-submits" action="{{route('traduceri.store')}}" method="POST">
		@csrf
		<input type="hidden" name="submited" value="create_bible">
		
		@foreach( $form_fields as $name => $label )
			@formgroup(['class'=>'w-full', 'required'=>'true',
				'label' => ['value'=>$label, 'class'=>'w-full'],
				'input' => ['id'=>$name.'_', 'name'=>$name, 'value'=>old('submited')==='create_bible'?old($name):''],
				'iErrors' => old('submited')==='create_bible'?$errors->get($name):[]
			])
			@endformgroup
		@endforeach		
		
		<div>
			<label for="version_public">Public</label>
			<input type="checkbox" value="1" name="public" id="version_public" checked>
		</div>
		
		<button type="submit" class="adminAddBtn btn-prevent-multiple-submits">
			Adauga!
		</button>
	</form>
</div>