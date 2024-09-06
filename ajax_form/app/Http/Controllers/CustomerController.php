<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Mail\CustomerCreated;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class CustomerController extends Controller
{
    //
    public function create()
    {
        return view('customers.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());

        // Validate the request data
        $validated = $request->validate([
            'first_name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        // Combine first_name and last_name
        $fullName = $validated['first_name'] . ' ' . $validated['last_name'];


        // Create a new customer record
        $customer = Customer::create($validated);

        // Send the email to the customer's email address
        // Mail::to($customer->email)->send(new CustomerCreated($customer));

        try {
            // Send the email to the customer's email address
            Mail::to($customer->email)->send(new CustomerCreated($customer,$fullName));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Mail sending failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Customer created, but the email could not be sent.',
            ], 500);
        }

        // Redirect to a specific route with a success message
        return response()->json([
            'success' => 'Customer created successfully.',
            'customer' => $customer
        ]);
    }
}
