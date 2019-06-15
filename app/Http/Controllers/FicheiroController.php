<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficheiro;
use Illuminate\Support\Facades\Storage;

class FicheiroController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required|file|mimes:pdf',
            'descricao' => 'required',
            'proposta_id' => 'required'
        ]);

        $name = $request->proposta_id . '_' . preg_replace('<\W+>', "_", $request->descricao);

        $ficheiro = new Ficheiro();
        $ficheiro->nome = $name; 
        $ficheiro->descricao = $request->descricao;
        $ficheiro->proposta_id = $request->proposta_id;
        $ficheiro->save();

        //* Guardar o ficheiro localmente na pasta ficheiros
        if ($file->isValid()) {
            Storage::disk('local')->putFileAs('ficheiros/' . $request->proposta_id, $file, $name . '.' . $file->getClientOriginalExtension());
        }

        return response()->json($ficheiro, 200);
    }

    public function downloadFicheiro($id)
    {
        $document = Document::findOrFail($id);
        $movement = Movement::where('document_id', '=', $document->id)->first();
        $unique_id = $movement->id . '.' . $document->type;
        $file = new File(storage_path('app/' . 'documents/' . $movement->account_id . '/' . $unique_id));
        
        return response()->download(
            storage_path('app/' . 'documents/' . $movement->account_id . '/' . $unique_id),
            $document->original_name);
    }

    public function getFicheiros($proposta_id)
    {
        return Ficheiro::where('proposta_id', $proposta_id)->get();
    }
}
