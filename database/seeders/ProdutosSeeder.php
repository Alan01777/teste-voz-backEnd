<?php

namespace Database\Seeders;

use App\Models\Produtos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Categorias;
use Illuminate\Database\Seeder;
use Random\RandomException;

class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $categorias = Categorias::where('id', '>', 0)->get();

        foreach ($categorias as $categoria) {
            Produtos::factory()->count(random_int(0,10))->create([
                'categoria_id' => $categoria['id'],
            ]);
        }
    }
}
