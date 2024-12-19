<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\File;
use App\Models\Peticione;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    // Constructor y middleware
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Mostrar vistas
    public function index(Request $request)
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage())->withInput();
        }
        return view('admin.peticiones.show', compact('user'));
    }

    public function dropUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/admin/users/index');
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect('/admin/users/index');
    }

    public function cambiarRol($id){
        try{
            $user=User::findOrFail($id);
            if($user->role == '0'){
                $user->role = '1';
            }
            $user->save();
        }catch (Exception $exception){
            return redirect()->back();
        }
        return redirect()->back();
    }
}
