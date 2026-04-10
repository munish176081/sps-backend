<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\LeadNotificationAdmin;
use App\Mail\LeadConfirmationUser;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_type' => 'nullable|string',
            'source_page' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'honeypot' => 'prohibited',
            'photo' => 'nullable|image|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // collect dynamic fields
        $data = $request->except(['form_type', 'source_page', 'honeypot', 'photo']);

        // upload file
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $filename = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('leads', $filename, 'r2');

            $data['photo'] = r2_url($path);
        }

        // convert stones to array
        if(isset($data['stones']) && is_string($data['stones'])) {
            $data['stones'] = array_map('intval', explode(',', $data['stones']));
        }

        // convert category to integer
        if(isset($data['stone_category'])) {
            $data['stone_category'] = (int) $data['stone_category'];
        }

        $lead = Lead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
            'product_id' => $request->input('product_id'),
            'form_type' => $request->input('form_type'),
            'source_page' => $request->input('source_page'),
            'data' => $data,
        ]);

        // Send admin notification
        Mail::to('munish.lyons@gmail.com')
            ->queue(new LeadNotificationAdmin($lead));

        // Send confirmation to user
        Mail::to($lead->email)
            ->queue(new LeadConfirmationUser($lead));

        return response()->json([
            'success' => true,
            'message' => 'Lead submitted successfully',
            'data' => $lead
        ], 201);
    }
}
