<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Peticione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCategoriasController extends Controller
{

    // Mostrar vistas
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    //Guardar
    public function create()
    {
        return view('admin.categorias.edit-add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|max:255',
        ]);
        $input = $request['nombre'];
        try {
            $category = new Categoria();
            $category->nombre = $input;
            $category->save();
            return redirect('admin/categorias/index');
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    //Borrar
    public function dropCategoria(Request $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            return redirect('/admin/categorias/index');
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect('/admin/categorias/index');
    }

    //Editar
    public function editCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit-peticion', compact('categoria'));
    }

    public function updateCategoria(Request $request)
    {
        $input = $request->all();
        try {
            $categoria = Categoria::findOrFail($request->id);
            $categoria->nombre = $input['nombre'];
            $categoria->save();
            return redirect('admin/categorias/index');
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
}
