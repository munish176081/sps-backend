<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadConfirmationUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    public function build()
    {
        $subject = match ($this->lead->form_type) {
            'samples' => 'Your Stone Sample Request',
            'fireplace_quote' => 'Your Fireplace Quote Request',
            'contact' => 'Thank you for contacting us',
            'brochure' => 'Your Brochure Request',
            default => 'Thank you for contacting us'
        };

        return $this->subject($subject)
            ->view('emails.user-confirmation', [
                'lead' => $this->lead
            ]);
    }
}
