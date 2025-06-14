<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
        */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'required|regex:/^[0-9+\s-]+$/|max:15',
            'street_address' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'required|digits_between:4,10',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a valid string.',
            'first_name.max' => 'First name cannot be longer than 255 characters.',

            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a valid string.',
            'last_name.max' => 'Last name cannot be longer than 255 characters.',

            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Contact number format is invalid. Only digits, spaces, plus (+), and dashes (-) are allowed.',
            'contact_number.max' => 'Contact number cannot be longer than 15 characters.',

            'street_address.required' => 'Street address is required.',
            'street_address.string' => 'Street address must be a valid string.',
            'street_address.max' => 'Street address cannot be longer than 255 characters.',

            'barangay.required' => 'Barangay is required.',
            'barangay.string' => 'Barangay must be a valid string.',
            'barangay.max' => 'Barangay cannot be longer than 255 characters.',

            'city.required' => 'City is required.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City cannot be longer than 255 characters.',

            'province.required' => 'Province is required.',
            'province.string' => 'Province must be a valid string.',
            'province.max' => 'Province cannot be longer than 255 characters.',

            'zip_code.required' => 'ZIP code is required.',
            'zip_code.digits_between' => 'ZIP code must be between 4 and 10 digits.',
        ]);

        // Add authenticated user ID to the validated data
        $validated['user_id'] = auth()->id();

        // Create the address record
        Address::create($validated);
        
        return redirect()->back()->with('status', 'Address added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $address = Address::findOrFail($id);

        // Authorize the user
        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'required|regex:/^[0-9+\s-]+$/|max:15',
            'street_address' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'required|digits_between:4,10',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a valid string.',
            'first_name.max' => 'First name cannot be longer than 255 characters.',

            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a valid string.',
            'last_name.max' => 'Last name cannot be longer than 255 characters.',

            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Contact number format is invalid. Only digits, spaces, plus (+), and dashes (-) are allowed.',
            'contact_number.max' => 'Contact number cannot be longer than 15 characters.',

            'street_address.required' => 'Street address is required.',
            'street_address.string' => 'Street address must be a valid string.',
            'street_address.max' => 'Street address cannot be longer than 255 characters.',

            'barangay.required' => 'Barangay is required.',
            'barangay.string' => 'Barangay must be a valid string.',
            'barangay.max' => 'Barangay cannot be longer than 255 characters.',

            'city.required' => 'City is required.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City cannot be longer than 255 characters.',

            'province.required' => 'Province is required.',
            'province.string' => 'Province must be a valid string.',
            'province.max' => 'Province cannot be longer than 255 characters.',

            'zip_code.required' => 'ZIP code is required.',
            'zip_code.digits_between' => 'ZIP code must be between 4 and 10 digits.',
        ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $address->update($validated);

        return redirect()->back()->with('status', 'Address updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Address::findOrFail($id);

        // Check if the authenticated user is the owner of the address
        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the address
        $address->delete();

        return redirect()->back()->with('status', 'Address deleted successfully.');
    }
}
