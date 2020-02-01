<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\FlagAdded;

class ModelHasFlagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Flag::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $flag, $comment_id)
    {
		$data = ['flag_records' => [], 'user_flag' => null ];
		$comment = \App\Comment::find($comment_id);

		$user_voted_before = \App\ModelHasFlag::where([
			'comment_id' => $comment_id, 
			'author' => Auth::id()
		])->first();

		if ( $user_voted_before ){
			$rec1 = $comment->flag_records()->firstOrCreate(
				['flag_id' => $user_voted_before->flag_id], 
				['count' => 0]
			);
			$rec1->decrement('count', 1);
			$data['flag_records'][] = $rec1;
		}
		$rec2 = $comment->flag_records()->firstOrCreate(
			['flag_id' => $flag->id], 
			['count' => 0]
		);
		$rec2->increment('count', 1);
		$data['flag_records'][] = $rec2;
		
		$data['user_flag'] = $comment->flags()
			->updateOrCreate(['author' => Auth::id()], [
				'flag_id' => $flag->id,
			]);
		return response()->json($data);
				
				//event(new FlagAdded($comment_id, $initial_flag, $new_flag));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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