<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property string $nome
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Produtos> $produtos
 * @property-read int|null $produtos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorias whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Categorias extends Model
{
    use HasFactory;
    protected $fillable = [
      'nome'
    ];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produtos::class, 'categoria_id');
    }
}
