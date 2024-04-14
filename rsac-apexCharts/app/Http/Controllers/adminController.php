<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class adminController extends Controller
{
    public function administracionView()
    {
        // consultar todos los usuarios con sus roles 
        $users = User::with('roles')->get();

        return Inertia::render('SideBarMenus/Administracion/Admin', [
            'users' => $users,
        ]);
    }

    public function registrar() {
        $name = request('name');
        $email = request('email');
        $password = request('password');

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();

        return redirect()->route('view.administracion');
    }

    public function asignarRol(){
        $id = request('id');
        $roles = request('roles');

        $user = User::find($id);
        
        $user->roles()->detach();

        // Asignar los nuevos roles
        foreach ($roles as $role) {
            $user->assignRole($role);
        }


    
    
        return redirect()->route('view.administracion');
    }
    
    public function eliminar() {
        $id = request('id');

        // eliminar los usuarios con el id recibido
        User::destroy($id);

        return redirect()->route('view.administracion');
    }

}
