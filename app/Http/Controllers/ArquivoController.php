<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ArquivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return View('arquivo.index')->with('arquivos',Arquivo::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return View('arquivo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Arquivo::class);
        $request->validate([
            'file' => 'required',
            'filename' => 'required|string|unique:arquivos,name'
        ]);

        // get file name
        $fileName = $request->filename;
        $filePath = $request->file('file')->storeAs('arquivos', $fileName, 'public');

        Arquivo::create([
            'name' => $fileName,
            'path' => $filePath
        ]);

		return redirect()->action([ArquivoController::class,'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function show(Arquivo $arquivo)
    {
        return redirect(asset($arquivo->url));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Arquivo $arquivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arquivo $arquivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arquivo $arquivo)
    {
        $this->authorize('delete', $arquivo);
        if( !Storage::disk('public')->exists($arquivo->path) ){
            $arquivo->delete();
            return back()->withErrors(['Aviso: inconsistência: o arquivo '.$arquivo->name. ' não existia no filesystem.']);
        }

        Storage::disk('public')->delete($arquivo->path);
        $arquivo->delete();
		return redirect()->action([ArquivoController::class,'index']);
    }
}
