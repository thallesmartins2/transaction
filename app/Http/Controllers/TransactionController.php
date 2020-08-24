<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Transaction;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        try {
            return response()->json($this->transactionService->getall(), Response::HTTP_OK); 
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
            return response()->json($this->transactionService->setTransaction($request), Response::HTTP_OK); 
        } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao salvar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->transactionService->getTransactionById($id), Response::HTTP_OK); 
        } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao listar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
        }
    }

    public function edit($id)
    {
        try {
            return response()->json($this->transactionService->editTransactionById($id), Response::HTTP_OK); 
        } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao editar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            return response()->json($this->transactionService->updateTransactionById($request, $id), Response::HTTP_OK); 
        } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao atualizar a transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
        }
    }

    public function destroy($id)
    {
        try {
            return response()->json($this->transactionService->deleteTransactionById($id), Response::HTTP_OK); 
        } catch (\Exception $ex) {
            return json_encode(['erro' => 'Erro ao deletar transação.'.$ex->getMessage()], Response::HTTP_NO_CONTENT);
        }
    }
}
