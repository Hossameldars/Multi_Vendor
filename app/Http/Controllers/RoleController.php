<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $roles=Role::all();
      return view('Dashboard.Role.index',compact('roles'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    $permissions = Permission::all();
    return view('Dashboard.Role.create', compact('permissions'));

    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{ 

    $request->validate([
        'name'         => 'required|string|unique:roles,name',
        'permission'   => 'required|array',
        'permission.*' => 'exists:permissions,id',
    ]);

    DB::beginTransaction();
    try {
        // 2. Create Role
        $role = Role::create([
            'name' => $request->name,
        ]);

  
        $permissionids = Permission::whereIn('id', $request->input('permission'))
            ->pluck('id')
            ->toArray();

        foreach ($permissionids as $permissionid) {
            RoleAbility::create([
                'role_id'    => $role->id,
                'permission_id' => $permissionid,
                'type'       => 'allow',
            ]);
        }

        
        DB::commit();

        return redirect()->route('roles.index')
                         ->with('success', 'Role created successfully.');

    } catch (\Exception $e) { 
        DB::rollBack();
        throw $e;
    }
}

    
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
          $role = Role::find($id);
$permissions = Permission::get();

$rolePermissions = DB::table("role_abilities")->where("role_id",$id)
->pluck('permission_id','permission_id')
->all(); 
// dd($permissions);
return view('Dashboard.Role.edit',compact('role','permissions','rolePermissions'));
    }

   public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'         => 'required|string|unique:roles,name,' . $role->id,
            'permission'   => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();
        try {
            $role->update(['name' => $request->name]);

            
            RoleAbility::where('role_id', $role->id)->delete();

            foreach ($request->input('permission') as $permissionId) {
                RoleAbility::create([
                    'role_id'       => $role->id,
                    'permission_id' => $permissionId,
                    'type'          => 'allow',
                ]);
            }

            DB::commit();
            return redirect()->route('roles.index')
                             ->with('success', 'Role updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
