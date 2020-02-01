<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\BibleResourceTrait;

class NotificationController extends Controller
{
	use BibleResourceTrait;

    public function index()
    {
		$auth = Auth::id();
		$data = \App\Notification::with('author')->where('notifiable_id', $auth)->paginate(50);
		
		foreach($data as &$notif){
			$notif->data = json_decode($notif->data);
		}
		
		return response()->json($data);
    }

    public function update(Request $req, $id)
    {
		$notification = $req['data'];
		$notif = Auth::user()->notifications()->find($id);
		if ($notif){
			if ($notification['read_at']){
				$notif->markAsRead();
			} else {
				$notif->read_at = null;
			}
			$notif->save();
			return response()->json($notif);
		}
    }
	
    public function markAllAsRead()
    {
		$user = Auth::user();

		foreach ($user->unreadNotifications as $notification) {
			$notification->markAsRead();
		}
    }
	
    public function get($id)
    {
		$notif = Auth::user()->notifications()->find($id);
		if ($notif){
			$notif->markAsRead();
			$notif_data = unserialize($notif->url_params);
			$qs = [];
			if ( isset($notif_data['comment']) ){
				$qs['comment'] = $notif_data['comment'];
			}
			if ( isset($notif_data['reply']) ){
				$qs['reply'] = $notif_data['reply'];
			}
			$url = $this->urlFromGlobalId($notif_data['g_verse'], $qs);
			return redirect($url);
		}
		abort(404, 'Nu a putut fi gasita aceasta resursa!');
    }

    public function destroy($id)
    {
		$notif = Auth::user()->notifications()->find($id);
		if ($notif){
			$notif->delete();
		}
		return ['id' => $id];
    }
	
	public function checkForNew(){
		$count = Auth::user()->unreadNotifications()->count();
		return response()->json(['unread_notifications_count' => $count]);
	}
}
