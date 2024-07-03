<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Customer::orderBy('id', 'desc')->get();
        return view('backend.v_customer.index', [
            'judul' => 'Customer',
            'sub' => 'Data Customer',
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_customer.create', [
            'judul' => 'Customer',
            'sub' => 'Tambah Customer'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //ddd($request);
        $validatedData = $request->validate([
            'nama_customer' => 'required',
            'email' => 'required',
            'hp' => 'required',
        ]);
        Customer::create($validatedData);
        return redirect('/customer')->with('success', 'Data berhasil tersimpan');
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
        $customer = Customer::findOrFail($id);
        return view('backend.v_customer.edit', [
            'judul' => 'Customer',
            'sub' => 'Ubah Customer',
            'edit' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $rules = [
            'nama_customer' => 'required',
            'email' => 'required',
            'hp' => 'required',
        ];

        if ($request->judul != $customer->judul) {
            $rules['judul'] = 'required|max:255|unique:customer';
        }

        // Validate input
        $validatedData = $request->validate($rules);

        // Update customer data
        $customer->nama_customer = $request->nama_customer;
        $customer->email = $request->email;
        $customer->hp = $request->hp;

        // Save updated customer
        $customer->save();

        // Redirect to index view
        return redirect()->route('customer.index')->with('success', 'Customer berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect('/customer');
    }
}
