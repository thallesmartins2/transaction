<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            return response()->json(Transaction::getall().' chegou index', Response::HTTP_OK); 
         } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao listar todas as transações.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
         }
    }

    // public function create()
    // {
    //     try {
    //         return response()->json(ConTransactiontrato::getAno(), Response::HTTP_OK); 
    //      } catch (\Exception $ex) {
    //         return json_encode(['erro' => 'Erro ao listar os anos por contrato.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
    //      }
    // }

    public function store(Request $request)
    {
        try {
            return response()->json(Transaction::putTransaction($request).' chegou store', Response::HTTP_OK); 
         } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao salvar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
         }
    }

    public function show($id)
    {
        try {
            return response()->json(Transaction::getTransictionById($id).' chegou show', Response::HTTP_OK); 
         } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao listar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
         }
    }

    public function edit($id)
    {
        try {
            return response()->json(Transaction::editTransactionById($id). 'chegou edit', Response::HTTP_OK); 
         } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao editar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
         }
    }

    public function update(Request $request, $id)
    {
        try {
            return response()->json(Transaction::updateTransactionById($request, $id), Response::HTTP_OK); 
         } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao atualizar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
         }
    }

    public function destroy($id)
    {
        try {
            return response()->json(Transaction::deleteTransactionById($id), Response::HTTP_OK); 
         } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao deletar transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
         }
    }
}
