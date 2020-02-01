<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Http\Request as Req;
use \App\Traits\BibleTrait;
		
class ChapterController extends Controller
{
	use BibleTrait;
	
	public function __construct($v, $b)
	{
			echo $v;
			echo $b;
	}
	//books au index=id
	public function index($v, $b){
		$data = [];
		$data['versions'] = $this->versions();
		$data['books'] = $this->books($v);
		$data['chapters'] = $this->chapters($v, $b);
		//inspect($data['chapters'], true);
		return view('chapters')->with(['data' => $data]);
	}
	
	public function create ($v, $b, Req $request)
	{
		//$present = $this->chapters($v, $b);
		//$next_index = $this->getMissingOrNext($present->chapters);
		$new_chapter = $this->book($v, $b)->chapters()->create($request->all());
		return back();
	}
	
	public function update_or_delete ($c_id, Req $request)
	{
		if ( $request->submit === 'update' ){
			$chapter = \App\Chapter::find($c_id);
			$chapter->index = $request->index;
			$chapter->title = $request->title;
			$chapter->save();
		}
		elseif ( $request->submit === 'delete' ){
			\App\Chapter::find($c_id)->delete();
		}
		return back();
	}
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