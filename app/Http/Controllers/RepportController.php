<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepportController extends Controller
{	
	private $accepted = [
		'App\Comment' => \App\Comment::class,
		'App\Reply' => \App\Reply::class
	];
	
	public function __construct (){

	}
	
    public function index()
    {
		
    }

    public function store(Request $req)
    {
		if ( in_array($req->model['type'], $this->accepted) ){
			$model = $this->accepted[$req->model['type']];
			$model = $model::findOrFail($req->model['id']);
			$repport = $model->repports()->updateOrCreate([
				'model_type' => get_class($model),
				'model_id' => $model->id,
				'repported_by' => auth()->id()
			], [
				'model_type' => get_class($model),
				'repported_by' => auth()->id(),
				'reason' => $req->reason
			]);
			return response()->json($repport);
		}
		abort(404);
    }

    public function destroy(Request $req, $repport_id)
    {
		\App\Repport::findOrFail($repport_id)->delete();
		return ['id' => $repport_id];
    }
}