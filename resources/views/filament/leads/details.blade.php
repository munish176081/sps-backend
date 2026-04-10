@php
use App\Models\Product;
use App\Models\Category;

$data = $lead->data ?? [];

/*
|--------------------------------------------------------------------------
| Resolve Stone Names
|--------------------------------------------------------------------------
*/

$stoneNames = [];

if(isset($data['stones'])){

    $stones = $data['stones'];

    if(is_string($stones)){
        $stones = explode(',', $stones);
    }

    $stoneNames = Product::whereIn('id', $stones)
        ->pluck('title')
        ->toArray();
}

/*
|--------------------------------------------------------------------------
| Resolve Stone Category Name
|--------------------------------------------------------------------------
*/

$stoneCategoryName = null;

if(isset($data['stone_category'])){
    $category = Category::find($data['stone_category']);
    $stoneCategoryName = $category?->name;
}

@endphp


<div style="font-family: sans-serif; color: #111827; padding: 10px;">

    <!-- Header -->
    <div style="display: flex; flex-wrap: wrap; border-bottom: 1px solid #e5e7eb; padding-bottom: 20px; margin-bottom: 20px; gap:20px;">

        <div style="flex:1; min-width:200px;">
            <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;">Customer Name</div>
            <div style="font-weight:600;font-size:16px;">{{ $lead->name }}</div>
        </div>

        <div style="flex:1; min-width:200px;">
            <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;">Email Address</div>
            <div style="font-weight:600;font-size:16px;color:#2563eb;">{{ $lead->email }}</div>
        </div>

        @if($lead->phone)
        <div style="flex:1; min-width:200px;">
            <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;">Phone</div>
            <div style="font-weight:600;font-size:16px;">{{ $lead->phone }}</div>
        </div>
        @endif

        <div style="flex:1; min-width:200px;">
            <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;">Form Type</div>
            <div style="font-weight:600;font-size:16px;">
                {{ ucfirst(str_replace('_',' ', $lead->form_type)) }}
            </div>
        </div>

        <div style="flex:1; min-width:200px;">
            <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;">Source Page</div>
            <div style="font-weight:600;font-size:16px;">{{ $lead->source_page }}</div>
        </div>

    </div>


    <!-- Additional Details -->
    @if($lead->data)

    <div>

        <div style="font-size:12px;font-weight:800;text-transform:uppercase;margin-bottom:15px;display:flex;align-items:center;">
            <div style="width:4px;height:16px;background:#2563eb;margin-right:8px;border-radius:2px;"></div>
            Additional Specifications
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:10px;">

            @foreach($lead->data as $key => $value)

            @if(!in_array($key,['terms','honeypot','name','email','phone','photo','message','stones','stone_category']))

            <div style="background:#f9fafb;border:1px solid #f3f4f6;padding:10px;border-radius:8px;">

                <div style="font-size:9px;font-weight:800;color:#6b7280;text-transform:uppercase;margin-bottom:4px;">
                    {{ ucwords(str_replace('_',' ', $key)) }}
                </div>

                <div style="font-size:13px;font-weight:600;color:#374151;">
                    {{ is_array($value) ? implode(', ', $value) : ucfirst($value) }}
                </div>

            </div>

            @endif

            @endforeach


            {{-- Stone Category --}}
            @if($stoneCategoryName)
            <div style="background:#f9fafb;border:1px solid #f3f4f6;padding:10px;border-radius:8px;">
                <div style="font-size:9px;font-weight:800;color:#6b7280;text-transform:uppercase;margin-bottom:4px;">
                    Stone Category
                </div>
                <div style="font-size:13px;font-weight:600;color:#374151;">
                    {{ $stoneCategoryName }}
                </div>
            </div>
            @endif


            {{-- Selected Stones --}}
            @if(count($stoneNames))
            <div style="background:#f9fafb;border:1px solid #f3f4f6;padding:10px;border-radius:8px;">
                <div style="font-size:9px;font-weight:800;color:#6b7280;text-transform:uppercase;margin-bottom:4px;">
                    Selected Stones
                </div>
                <div style="font-size:13px;font-weight:600;color:#374151;">
                    {{ implode(', ', $stoneNames) }}
                </div>
            </div>
            @endif

        </div>

    </div>

    @endif


    <!-- Message -->
    @if($lead->message)

    <div style="margin-top:25px;padding-top:20px;border-top:1px solid #f3f4f6;">

        <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;margin-bottom:8px;">
            Message
        </div>

        <div style="font-size:14px;color:#374151;">
            {{ $lead->message }}
        </div>

    </div>

    @endif


    <!-- Photo -->
    @if(isset($lead->data['photo']))

    <div style="margin-top:25px;padding-top:20px;border-top:1px solid #f3f4f6;">

        <div style="font-size:10px;font-weight:bold;color:#9ca3af;text-transform:uppercase;margin-bottom:10px;">
            Photo of space
        </div>

        <img
            src="{{ $lead->data['photo'] }}"
            style="max-height:300px;border-radius:12px;box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1);border:1px solid #e5e7eb;"
        >

    </div>

    @endif

</div>