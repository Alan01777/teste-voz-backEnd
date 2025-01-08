<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property string $preco
 * @property int $categoria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Categorias $Categoria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos wherePreco($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produtos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Produtos extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria_id'
    ];


    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categorias::class);
    }
}
