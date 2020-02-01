@if (request('edit'))
	<div class="m-2 p-4 section verse_form">
		<strong>Adauga versete:</strong>

		{{ Form::open([ 'url' => route('traduceri.carti.capitole.versete.store', ['version' => $version, 'book' => $book, 'chapter' => $chapter]), 'method' => 'post' ]) }}
			<div>
				{{ Form::text('regexp', '', [
					'placeholder' => 'Regexp...', 
					'class' => 'w-full border border-gray-600 rounded px-2 py-2'
				]) }}
			</div>
			<br>
			<div>
				{{ Form::textarea('texts', '', [
					'placeholder' => 'Versete...', 
					'class' => 'w-full border border-gray-600 rounded px-2 py-2'
				]) }}
			</div>
			<div class="flex ml-auto">
				{{ Form::submit('preview', ['class'=>'bg-gray-400 hover:bg-gray-700 font-bold px-3 py-1 rounded', 'name'=>'submit']) }}
				{{ Form::submit('add', ['class'=>'bg-gray-900 hover:bg-gray-600 text-white font-bold px-3 py-1 rounded', 'name'=>'submit']) }}
			</div>
		{{ Form::close() }}
	</div>
@endif