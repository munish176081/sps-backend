<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;

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
            'brochure_download' => 'Your Brochure Request',
            default => 'Thank you for contacting us'
        };

        $mail = $this->subject($subject)
            ->view('emails.user-confirmation', [
                'lead' => $this->lead
            ]);

        if ($this->lead->form_type === 'brochure_download') {

            $data = $this->lead->data ?? [];
            $brochureType = $data['brochure_type'] ?? null;

            $slug = last(explode('/', trim($this->lead->source_page, '/')));
            $category = Category::where('slug', $slug)->first();

            if ($category && $category->brochures) {

                $brochures = $category->brochures;

                $categoryName = $category->name ?? 'Stone';

                // Project Book
                if ($brochureType === 'project_book' && !empty($brochures['project_book']['file'])) {

                    $mail->attachFromStorageDisk(
                        'r2',
                        $brochures['project_book']['file'],
                        $categoryName . '-Project-Book.pdf'
                    );
                }

                // Range
                if ($brochureType === 'range' && !empty($brochures['range']['file'])) {

                    $mail->attachFromStorageDisk(
                        'r2',
                        $brochures['range']['file'],
                        $categoryName . '-Range-Brochure.pdf'
                    );
                }
            }
        }

        return $mail;
    }
}
