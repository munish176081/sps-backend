<h2>
@if($lead->form_type === 'brochure_download')
Your brochure is ready
@else
Thank you for your {{ str_replace('_',' ', $lead->form_type) }} request
@endif
</h2>

<p>Hi {{ $lead->name }},</p>

@if($lead->form_type === 'brochure_download')

<p>
Thank you for your interest in <strong>Splendour in Stone</strong>.
Your requested brochure is attached to this email.
</p>

<p>
You can review our stone collections, project inspirations and product ranges inside the brochure.
If you have any questions or would like a quote, feel free to reply to this email.
</p>

@else

<p>
Thank you for your {{ str_replace('_',' ', $lead->form_type) }} request.
Our team has received your enquiry and will get back to you shortly.
</p>

@endif

@if($lead->product)
<p><strong>Product:</strong> {{ $lead->product->title }}</p>
@endif

@if($lead->message)
<p><strong>Your Message:</strong> {{ $lead->message }}</p>
@endif


@if($lead->data)

<h3 style="margin-top:20px;">Your Request Summary</h3>

@foreach($lead->data as $key => $value)

@if(!in_array($key, [
    'terms',
    'honeypot',
    'name',
    'email',
    'phone',
    'message',
    'product_id',
    'photo',
    'stones',
    'stone_category'
]))

<p>

<strong>
{{ 
$key === 'stones_names' ? 'Selected Stones' : 
($key === 'stone_category_name' ? 'Stone Category' : 
ucwords(str_replace('_',' ', $key)))
}}
:
</strong>

@if($key === 'stones_names')

{{ $value }}

@elseif(is_array($value))

{{ implode(', ', $value) }}

@else

{{ ucfirst($value) }}

@endif

</p>

@endif

@endforeach

@endif


<p style="margin-top:20px;">
If you have any additional questions, feel free to reply to this email.
</p>

<p>
Regards,<br>
<strong>Splendour in Stone Team</strong>
</p>