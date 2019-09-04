<?php

namespace App\Http\Controllers;

use App\Ficheiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FicheiroController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required|file|mimes:pdf',
            'descricao' => 'required',
            'proposta_id' => 'required',
        ]);

        $name = $request->proposta_id . '_' . preg_replace('<\W+>', "_", $request->descricao) . '.' . $file->getClientOriginalExtension();

        $ficheiro = new Ficheiro();
        $ficheiro->nome = $name;
        $ficheiro->descricao = $request->descricao;
        $ficheiro->proposta_id = $request->proposta_id;
        $ficheiro->save();

        //* Guardar o ficheiro localmente na pasta ficheiros
        if ($file->isValid()) {
            Storage::disk('local')->putFileAs('ficheiros/' . $request->proposta_id, $file, $name);
        }

        return response()->json($ficheiro, 200);
    }

    public function deleteFicheiros($id)
    {
        //? Apagar todos os ficheiros
        Ficheiro::where('proposta_id', $id)->delete();

        Storage::disk('local')->deleteDirectory('ficheiros/' . $id);

        return response()->json('Ficheiros apagados com sucesso!', 200); 
    }

    public function downloadFicheiro($proposta_id, $descricao)
    {
        $ficheiro = Ficheiro::where('proposta_id', $proposta_id)->where('descricao', $descricao)->first();
        $file = new File(storage_path('app/' . 'ficheiros/' . $proposta_id . '/' . $ficheiro->nome));


        return response()->download(
            storage_path('app/' . 'ficheiros/' . $proposta_id . '/' . $ficheiro->nome),
            $ficheiro->nome);
    }

    public function getFicheiros($proposta_id)
    {
        return Ficheiro::where('proposta_id', $proposta_id)->get();
    }
}
