<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categoria;
use App\Models\Peticione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\User;
use App\Http\Controllers\Controller;
class AdminPeticionesController extends Controller{
    // Constructor y middleware
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Mostrar vistas
    public function index(Request $request)
    {
        $peticiones = Peticione::all();
        return view('admin.peticiones.index', compact('peticiones'));
    }

    public function show(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage())->withInput();
        }

        return view('admin.peticiones.show', compact('peticion'));
    }


    // Crear y almacenar peticiones
    public function create(Request $request)
    {
        try {
            $user = Auth::user();
            $categorias = Categoria::orderBy('nombre', 'asc')->get();
            return view('admin.peticiones.edit-add', compact('categorias'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'category' => 'required',
            'file' => 'required',
        ]);
        $input = $request->all();
        try {
            $category = Categoria::findOrFail($input['category']);
            $user = Auth::user(); //usuario autenticado
            $peticion = new Peticione($input);
            $peticion->categoria()->associate($category);
            $peticion->user()->associate($user);
            $peticion->firmantes = 0;
            $peticion->estado = 'pendiente';
            $res = $peticion->save();
            if ($res) {
                $res_file = $this->fileUpload($request, $peticion->id);
                if ($res_file) {
                    return redirect('/admin');
                }
                return back()->withError('Error creando la peticion')->withInput();
            }
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    // Firmar y eliminar peticiones
    public function cambiarEstado(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
            if($peticion->estado == 'pendiente') {
                $peticion->estado = 'aceptada';
            }
            else{
                $peticion->estado = 'pendiente';
            }
            $peticion->save();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->back();
    }
    public function dropPeticion(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
            $peticion->firmas()->detach();
            $peticion->delete();
            return redirect('/admin/peticiones/index');
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect('/admin/peticiones/index');
    }

    // Editar una petición existente
    public function editPeticion(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
            $categorias = Categoria::orderBy('nombre', 'asc')->get();
            return view('admin.peticiones.edit-peticion', compact('categorias', 'peticion'));
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'category' => 'required',
            'file',
        ]);

        try {
            $peticion = Peticione::findOrFail($id);
            $peticion->titulo = $request->input('titulo');
            $peticion->descripcion = $request->input('descripcion');
            $peticion->destinatario = $request->input('destinatario');
            $peticion->categoria_id = $request->input('category');
            $res = $peticion->save();

            if ($res) {
                $res_file = $this->fileUpload($request, $peticion->id);
            }
            return redirect()->route('adminpeticiones.index', $id)->with('success', 'Petición actualizada con éxito');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }

    // Cargar archivos
    public function fileUpload(Request $req, $peticione_id = null)
    {
        $file = $req->file('file');

        if ($file) {
            $existingFile = File::where('peticione_id', $peticione_id)->first();

            if ($existingFile) {
                $filePath = public_path('peticiones/' . $existingFile->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $existingFile->delete();
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('peticiones'), $filename);

            $fileModel = new File;
            $fileModel->peticione_id = $peticione_id;
            $fileModel->name = $filename;
            $fileModel->file_path = $filename;

            $res = $fileModel->save();

            if ($res) {
                return response()->json(['status' => 'success', 'data' => $fileModel]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'File upload failed'], 500);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'No file uploaded'], 400);
    }
}
