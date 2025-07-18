<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tablas relacionadas (opcional)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Lista de permisos a crear
        $permisos = [
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver clientes',
            'ver personal',
            'ver moviles',
            'crear moviles',
            'editar moviles',
            'eliminar moviles',
            'restaurar moviles',
            'ver control',
            'ver programa',
            'ver diseño de concreto',
            'ver boletas',
            'ver guias de remision',
            'ver tipo concreto',
            'crear tipo concreto',
            'editar tipo concreto',
            'eliminar tipo concreto',
            'restaurar tipo concreto',
            'ver metodo colocacion',
            'crear metodo colocacion',
            'editar metodo colocacion',
            'eliminar metodo colocacion',
            'restaurar metodo colocacion',
            'ver bomba',
            'crear bomba',
            'editar bomba',
            'eliminar bomba',
            'restaurar bomba',
            'ver tipo cemento',
            'crear tipo cemento',
            'editar tipo cemento',
            'eliminar tipo cemento',
            'restaurar tipo cemento',
            'ver estructura',
            'crear estructura',
            'editar estructura',
            'eliminar estructura',
            'restaurar estructura',
            'ver obra',
            'crear obra',
            'editar obra',
            'eliminar obra',
            'restaurar obra',
            'ver resistencia',
            'crear resistencia',
            'editar resistencia',
            'eliminar resistencia',
            'restaurar resistencia',
            'ver slam',
            'crear slam',
            'editar slam',
            'eliminar slam',
            'restaurar slam',
        ];

        // Crear permisos
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles y asignar permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $moderador = Role::firstOrCreate(['name' => 'laboratorista']);
        $moderador->syncPermissions([
            'ver usuarios',
            'ver control',
        ]);

        $usuario = Role::firstOrCreate(['name' => 'usuario']);
        // este rol no tiene permisos asignados directamente
    }
}
