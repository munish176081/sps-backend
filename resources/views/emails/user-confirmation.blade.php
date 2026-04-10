<h2>
Thank you for your {{ str_replace('_',' ', $lead->form_type) }} request
</h2>

<p>Hi {{ $lead->name }},</p>

<p>
Thank you for your {{ str_replace('_',' ', $lead->form_type) }} request.
Our team has received your enquiry and will get back to you shortly.
</p>

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