<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class LeadNotificationAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    public function build()
    {

        $data = $this->lead->data ?? [];

        /*
    |--------------------------------------------------------------------------
    | Convert Stones IDs → Product Names
    |--------------------------------------------------------------------------
    */

        if (isset($data['stones'])) {

            $stones = $data['stones'];

            if (is_string($stones)) {
                $stones = explode(',', $stones);
            }

            $data['stones_names'] = Product::whereIn('id', $stones)
                ->pluck('title')
                ->implode(', ');
        }

        /*
    |--------------------------------------------------------------------------
    | Convert Stone Category ID → Category Name
    |--------------------------------------------------------------------------
    */

        if (isset($data['stone_category'])) {

            $category = \App\Models\Category::find($data['stone_category']);

            if ($category) {
                $data['stone_category_name'] = $category->name;
            }
        }

        $this->lead->data = $data;

        $subject = match ($this->lead->form_type) {
            'contact' => 'New Contact Enquiry - ' . $this->lead->name,
            'samples' => 'New Sample Request - ' . $this->lead->name,
            'fireplace_quote' => 'New Fireplace Quote Request - ' . $this->lead->name,
            'brochure' => 'New Brochure Download - ' . $this->lead->name,
            default => 'New Website Lead - ' . $this->lead->name
        };

        return $this->subject($subject)
            ->view('emails.admin-lead', [
                'lead' => $this->lead,
                'data' => $data
            ]);
    }
}
