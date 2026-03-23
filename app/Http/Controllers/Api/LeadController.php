<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'nullable|string',
            'source_page' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'data' => 'nullable|array',
            'honeypot' => 'prohibited'
        ]);

        $data = $validated['data'] ?? [];

        $lead = Lead::create([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'] ?? null,
            'product_id' => $data['product_id'] ?? null,
            'form_type' => $validated['form_type'] ?? null,
            'source_page' => $validated['source_page'] ?? null,
            'data' => $data,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lead submitted successfully',
            'data' => $lead
        ], 201);
    }
}
