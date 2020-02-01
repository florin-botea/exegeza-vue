<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Welcome extends Notification
{
    use Queueable;
		
		private $data = [];
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(\App\User $user)
    {
		//pot avea aici un switch ca sa le dau un text mai dragut in functie de permisiune
		$this->data['text'] = "Bine ai venit, $user->name! Speram sa ai o experienta placuta pe site-ul nostru. Inainte de a incepe sa postezi, sau sa ai orice activitate pe platforma, te rugam sa citesti regulamentul din sectiunea: habar n-am.";
		$this->data['from'] = 0; //system
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
