<?php

namespace App\Http\Controllers;

use App\Models\Diarista;
use Illuminate\Http\Request;

class DiaristaController extends Controller
{
    /**
     * Lista as diaristas
     */
    public function index()
    {
        $diaristas = Diarista::get();

        return view('index', [
            'diaristas' => $diaristas
        ]);
    }

    /**
     * Mostra o formulário de criação
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Cria uma diárista no banco de dados
     */
    public function store(Request $request)
    {
        $dados = $request->except('_token');
        $dados['foto_usuario'] = $request->foto_usuario->store('public');

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', ' ', '-'], '', $dados['telefone']);

        Diarista::create($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     * Mostra o formulário de edição populado
     */
    public function edit(int $id)
    {
        $diarista = Diarista::findOrFail($id);

        return view('edit', ['diarista' => $diarista]);
    }

    /**
     * Atualiza uma diárista no banco de dados
     */
    public function update(int $id, Request $request)
    {
        $diarista = Diarista::findOrFail($id);

        $dados = $request->except(['_token', '_method']);

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', ' ', '-'], '', $dados['telefone']);


        if ($request->hasFile('foto_usuario')) {
            $dados['foto_usuario'] = $request->foto_usuario->store('public');
        }

        $diarista->update($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     * Apaga uma diárista no banco de dados
     */
    public function destroy(int $id)
    {
        $diarista = Diarista::findOrFail($id);

        $diarista->delete();

        return redirect()->route('diaristas.index');
    }
}
