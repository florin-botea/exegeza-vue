@php
	$form_fields = ['name' => 'Denumire versiune:', 'alias' => 'Alias versiune:', 'slug' => 'Parametru in url:'];
@endphp

<div class="m-5">
	<strong>Editeaza o versiune:</strong>
	@foreach($data['versions']['data'] as $version)
		<div class="relative">
			<form class="form-prevent-multiple-submits" 
			action="{{route('traduceri.update', ['traduceri' => $version->slug])}}" method="POST">
				@csrf
				@method('patch')
				<input type="hidden" name="submited" value="edit_bible_{{$version->id}}">
				
				@foreach($form_fields as $name => $label)
					@formgroup(['class'=>'w-full', 'required'=>'true',
						'label' => ['value'=>$label, 'class'=>'w-full'],
						'input' => ['id'=>'book_'.$version->id.$name, 'name'=>$name, 'value'=>$version[$name]],
						'iErrors' => old('submited')==='edit_bible_'.$version->id?$errors->get($name):[]
					])
					@endformgroup
				@endforeach
				
				<div>
					<label for="version_public">Public</label>
					<input type="checkbox" value="1" name="public" id="version_public" {{$version->public ? 'checked' : ''}}>
				</div>
				<br>
				<button type="submit" class="adminUpdateBtn btn-prevent-multiple-submits">
					Actualizeaza!
				</button>
			</form>
			<form action="{{route('traduceri.destroy', ['traduceri' => $version->slug])}}" method="POST">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
				<input type="hidden" name="id" value="{{$version->id}}">
				<button type="submit" class="adminDeleteBtn absolute right-0 bottom-0 btn-prevent-multiple-submits">
					Sterge!
				</button>
			</form>
		</div>
	@endforeach
</div>