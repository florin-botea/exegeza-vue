<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RepliedToMyPost extends Notification
{
    use Queueable;
		
	private $data = [];
	public $text1 = '$[subject] a adaugat un raspuns la o postare de-a ta.';
	public $text2 = '$[subject] si inca $[from_more] persoane au adaugat un raspuns la o postare de-a ta.';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
		$this->data = $data;
			
		$query = DB::table('notifications')->where([
			'type' => __class__,
			'related_model' => $this->data['related_model'],
			'related_model_id' => $this->data['related_model_id'],
		]);
		$already_notified = $query->first();
		if ( $already_notified ){
			if ( $already_notified->from == Auth::id() ){
				//abort pt ca ar da doua notificari la rand pe acelasi subiect
				$this->data['notification_aborted'] = true;
				return;
			}
			//daca e deja deschisa o notificare pe subiectul asta, o editez si abortez notificarea
			$query->update([
				'from' => Auth::id(),
				'from_more' => $already_notified->from_more + 1,
				'text' => $this->text2,
				'read_at' => null
			]);
			$this->data['notification_aborted'] = true;
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
