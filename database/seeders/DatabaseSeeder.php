<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermisoSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(ProvinciaSeeder::class);
        $this->call(DistritoSeeder::class);
        $this->call(MovilSeeder::class);
        $this->call(MetodoColocacionSeeder::class);
        $this->call(ResistenciaSeeder::class);
        $this->call(EstructuraSeeder::class);
        $this->call(TipoCementoSeeder::class);
        $this->call(SlamSeeder::class);
        $this->call(TipoPersonalSeeder::class);
        $this->call(SedeSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(PiedraSeeder::class);
        $this->call(PersonalSeeder::class);
    }
}
