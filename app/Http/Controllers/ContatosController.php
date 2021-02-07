<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contatos;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ContatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contatos::orderBy('nome', 'ASC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newContato = new Contatos;
        if (isset($request->imagem)) {
            $image_64 = $request->imagem;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.' . $extension;
            Storage::disk('public')->put($imageName, base64_decode($image));
            $newContato->imagem = $imageName;
        }
        $newContato->nome = $request->contato['nome'];
        $newContato->telefone = $request->contato['telefone'];
        if (isset($request->contato['email']) && $request->contato['email'] !== "") {
            $newContato->email = $request->contato['email'];
        }
        if (isset($request->contato['endereco']) && $request->contato['endereco'] !== "") {
            $newContato->endereco = $request->contato['endereco'];
        }
        $newContato->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingContato = Contatos::find($id);
        if ($existingContato) {
            $existingContato->nome = $request->contato['nome'];
            $existingContato->email = ($request->contato['email'] ? $request->contato['email'] : null);
            $existingContato->telefone = $request->contato['telefone'];
            if (isset($request->imagem)) {
                $image_64 = $request->imagem;
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid() . '.' . $extension;
                Storage::disk('public')->put($imageName, base64_decode($image));
                $existingContato->imagem = $imageName;
            }
            $existingContato->endereco = ($request->contato['endereco'] ? $request->contato['endereco'] : null);
            $existingContato->updated_at = Carbon::now();
            $existingContato->save();
            return $existingContato;
        }
        return "Este contato não existe.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingContato = Contatos::find($id);
        if ($existingContato) {
            $existingContato->delete();
            return "Item successfully deleted.";
        }
        return "Este contato não existe.";
    }
}
