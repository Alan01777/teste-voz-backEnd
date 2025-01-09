<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProdutoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($produto) {
                if (!$produto) {
                    return null;
                }
                return [
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'preco' => $produto->preco,
                    'descricao' => $produto->descricao,
                    'created_at' => $produto->created_at,
                    'updated_at' => $produto->updated_at,
                    'categoria' => $produto->categoria ? [
                        'id' => $produto->categoria->id,
                        'nome' => $produto->categoria->nome,
                        'created_at' => $produto->categoria->created_at,
                        'updated_at' => $produto->categoria->updated_at,
                    ] : null,
                ];

            })->filter()->values(),
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}
