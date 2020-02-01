<?php

namespace App\Http\Controllers;

use App\Http\Requests\BibleBookPost;
use Request;
use Illuminate\Http\Request as Req;
use App\Traits\BibleTrait;
		
class BookController extends Controller
{
	use BibleTrait;
	
	public function __construct()
	{
		
	}
	
	public function index($v){
		$data = [];
		$data['versions'] = $this->versions();
		$data['books'] = $this->books($v);
		return view('books')->with(['data' => $data]);
	}

	public function create ($v, BibleBookPost $request)
	{
		$book = \App\Book::create( [
			'bible_id' => $v,
			'name' => $request->name,
			'index' => $request->index
		]);
		return back();
	}
	
	public function update_or_delete ($b_id, Req $request)
	{
		if ( $request->submit === 'update' ){
			$book = \App\Book::find($b_id);
			$book->index = $request->index;
			$book->name = $request->name;
			$book->save();
		}
		elseif ( $request->submit === 'delete' ){
			\App\Book::find($b_id)->delete();
		}
		return back();
	}
	
	//

}
 
function inspect($data, $json = false){
	?>
	<pre>
	<?php
		if($json === true){
			print_r(json_encode($data, JSON_PRETTY_PRINT));
			die();
		}
		print_r($data);
		die();
	?>
	<pre>
	<?php
}