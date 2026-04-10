<h2>
New {{ ucfirst(str_replace('_',' ', $lead->form_type)) }} Received
</h2>

<p><strong>Name:</strong> {{ $lead->name }}</p>
<p><strong>Email:</strong> {{ $lead->email }}</p>
<p><strong>Phone:</strong> {{ $lead->phone }}</p>

@if($lead->product)
<p><strong>Product:</strong> {{ $lead->product->title }}</p>
@endif

@if($lead->message)
<p><strong>Message:</strong> {{ $lead->message }}</p>
@endif

<p><strong>Form Type:</strong> {{ ucfirst(str_replace('_',' ', $lead->form_type)) }}</p>

<p><strong>Source Page:</strong> {{ $lead->source_page }}</p>

@if($lead->data)

<h3 style="margin-top:20px;">Additional Details</h3>

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
}}:
</strong>

@if($key === 'stones_names')
{{ $value }}

@elseif(is_array($value))
{{ implode(', ', $value) }}

@elseif($key === 'photo' && $value)

<br>
<img src="{{ $value }}" style="max-width:300px;border-radius:8px;">

@else

{{ ucfirst($value) }}

@endif

</p>

@endif

@endforeach

@endif