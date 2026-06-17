<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins=Admin::all();
        return view('Dashboard.Admin.index',compact('admins'));
    }

  
    public function create()
    {
      $roles= Role::all();
        return view('Dashboard.Admin.create',compact('admins','roles'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
          'name'=>'required|string|max:255',
          'roles'=>'required|array'
        ]);
        $admin=Admin::create([

        ]);
      $admin->roles()->attach($request->roles);
      return redirect()->route('admin.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
