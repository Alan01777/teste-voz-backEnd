<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProdutosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            return [
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string',
                'preco' => 'required|numeric',
                'categoria_id' => 'required|exists:categorias,id',
            ];
        }
        return [
            'nome' => 'string|max:255',
            'descricao' => 'string',
            'preco' => 'numeric',
            'categoria_id' => 'exists:categorias,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'preco.required' => 'O campo preço é obrigatório.',
            'preco.numeric' => 'O campo preço deve ser um número.',
            'categoria_id.required' => 'O campo categoria_id é obrigatório.',
            'categoria_id.exists' => 'A categoria informada não existe.',
        ];
    }

    protected function failedValidation(Validator $validator): never
    {
        $errors = $validator->errors()->toArray();
        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
