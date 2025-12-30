<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // List customer milik owner yang login
    public function index()
    {
        $ownerId = Auth::user()->owner_id;
        $customers = Customer::where('owner_id', $ownerId)->latest()->get();

        return view('customer.index', compact('customers'));
    }

    // Store customer baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'required',
            'alamat' => 'required|string',
        ]);

        Customer::create([
            'owner_id' => Auth::user()->owner_id, // otomatis dari owner login
            'nama'     => $request->nama,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
        ]);

        return back()->with('success', 'Customer berhasil ditambahkan');
    }

    // Update customer
    public function update(Request $request, $id)
    {
        $customer = Customer::where('owner_id', Auth::user()->owner_id)->findOrFail($id);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'required',
            'alamat' => 'required|string',
        ]);

        $customer->update([
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Customer berhasil diupdate');
    }

    // Delete customer
    public function destroy($id)
    {
        $customer = Customer::where('owner_id', Auth::user()->owner_id)->findOrFail($id);
        $customer->delete();

        return back()->with('success', 'Customer berhasil dihapus');
    }
}
