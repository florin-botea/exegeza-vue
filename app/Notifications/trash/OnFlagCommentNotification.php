<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OnFlagCommentNotification extends Notification
{
    use Queueable;
		
		private $data = [];
		public $text1 = 'Postarea ta a primit un nou flag.';
		public $text2 = 'Postarea ta a primit inca $[from_more] flag-uri.';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
      $this->data = $data;
			$flag = \App\ModelHasFlag::where([
				'comment_id' => request('comment'), 
				'author' => Auth::id()
			])->first();
			
			if ($flag && $flag->created_at != $flag->updated_at){
				//adica nu e prima data cand votezi
				$this->data['notification_aborted'] = true;
				return;
			}
			
			$query = DB::table('notifications')->where([
				'type' => 'App\Notifications\OnFlagCommentNotification',
				'read_at' => null,
				'url' => $this->data['url'],
			]);
			$already_notified = $query->first();
			
			if ( $already_notified ){
				//adica daca mai am notificari de acest gen la acest comentariu
				$this->data['from_more'] = $already_notified->from_more + 1;
				$this->data['text'] = $this->text2;
				$query->update([
					'from_more' => $already_notified->from_more + 1,
					'text' => $this->text2,
					'read_at' => null
				]);
				$this->data['notification_aborted'] = true;
				return;
			}
			else {
				$this->data['text'] = $this->text1;
			}
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
      return [CustomDbChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->data;
    }
}
