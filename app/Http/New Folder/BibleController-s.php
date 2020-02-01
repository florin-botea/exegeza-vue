<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Http\Request as Req;
use \App\Traits\BibleTrait;
use \App\Http\Requests\BibleVersionPost;
		
class BibleController extends Controller
{
	use BibleTrait;
	
	public function __construct()
	{
		
	}
	
	public function index(){
		$data['versions'] = $this->versions();
		return view('bibles')->with(['data' => $data]);
	}

	public function create (BibleVersionPost $request)
	{
		$version = \App\Bible::create( $request->all() );
		return back();
	}
	
	public function update_or_delete ($v_id, BibleVersionPost $request)
	{
		if ( $request->submit === 'update' ){
			$version = \App\Bible::find($v_id)->update([
				'name' => $request->name,
				'alias' => $request->alias,
			]);
		}
		elseif ( $request->submit === 'delete' ){
			\App\Bible::find($v_id)->delete();
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