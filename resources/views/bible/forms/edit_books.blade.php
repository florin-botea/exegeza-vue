@php
	$form_fields = ['index' => 'Index carte', 'name' => 'Denumire carte:', 'slug' => 'Parametru in url:'];
@endphp

<div class="m-5">
	<strong>Editeaza o carte:</strong>
	@foreach( $data['books']['data'] as $book )
		<div class="relative">
			<form class="form-prevent-multiple-submits" action="{{route('traduceri.carti.update', [
			'traducere' => request('version'), 'carte' => $book->slug])}}" method="POST">
				@csrf
				@method('patch')
				<input type="hidden" name="submited" value="edit_book_{{$book->id}}">
				
				@foreach($form_fields as $name => $label)
					@formgroup(['class'=>'w-full', 'required'=>'true',
						'label' => ['value'=>$label, 'class'=>'w-full'],
						'input' => ['id'=>'book_'.$book->id.$name, 'name'=>$name, 'value'=>$book[$name]],
						'iErrors' => old('submited')==='edit_book_'.$book->id?$errors->get($name):[]
					])
					@endformgroup
				@endforeach

				<button type="submit" class="adminUpdateBtn btn-prevent-multiple-submits">
					Actualizeaza!
				</button>
			</form>
			<form class="form-prevent-multiple-submits" action="{{route('traduceri.carti.destroy', [
			'traducere' => request('version'), 'carte' => $book->slug])}}" method="POST">
				@csrf
				<input type="hidden" name="_method" value="DELETE">
				<button type="submit" class="adminDeleteBtn absolute right-0 bottom-0 btn-prevent-multiple-submits">
					Sterge!
				</button>
			</form>
		</div>
	@endforeach
</div>