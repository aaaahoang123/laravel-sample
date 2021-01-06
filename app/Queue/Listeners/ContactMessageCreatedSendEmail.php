<?php

namespace App\Queue\Listeners;

use App\Queue\Events\ContactMessageCreated;
use App\Repositories\Contract\ContactMessageRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class ContactMessageCreatedSendEmail implements ShouldQueue
{
    private ContactMessageRepository $contactMessageRepo;

    /**
     * Create the event listener.
     *
     * @param ContactMessageRepository $contactMessageRepo
     */
    public function __construct(
        ContactMessageRepository $contactMessageRepo
    )
    {
        $this->contactMessageRepo = $contactMessageRepo;
    }

    /**
     * Handle the event.
     *
     * @param  ContactMessageCreated  $event
     * @return void
     */
    public function handle(ContactMessageCreated $event)
    {
        $contactMessage = $this->contactMessageRepo->find($event->contactMessage);
        Mail::send('mail.contact-message-created', compact('contactMessage'), function($message) use ($contactMessage){
            $message->to('shinkenger.vn9x@gmail.com', $contactMessage->customer->name)->subject($contactMessage->subject);
        });
        $this->contactMessageRepo->markAsNotified($contactMessage->id);
    }
}
