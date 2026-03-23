<div class="space-y-3">

    <div><strong>Name:</strong> {{ $lead->name }}</div>
    <div><strong>Email:</strong> {{ $lead->email }}</div>
    <div><strong>Phone:</strong> {{ $lead->phone }}</div>
    <div><strong>Form:</strong> {{ $lead->form_type }}</div>
    <div><strong>Source Page:</strong> {{ $lead->source_page }}</div>

    @if($lead->data)
        <div class="mt-4">
            <strong>Additional Data</strong>
            <pre class="bg-gray-100 p-3 rounded text-xs">
{{ json_encode($lead->data, JSON_PRETTY_PRINT) }}
            </pre>
        </div>
    @endif

</div>