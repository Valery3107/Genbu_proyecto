<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerarCodigoAcceso extends Command
{
    protected $signature = 'genbu:codigo {rol : veterinario o secretaria}';

    protected $description = 'Genera un código de acceso de un solo uso para crear una cuenta';

    public function handle(): int
    {
        $rol = $this->argument('rol');
        $prefijos = ['veterinario' => 'GNB-VET-', 'secretaria' => 'GNB-SEC-'];

        if (! isset($prefijos[$rol])) {
            $this->error('El rol debe ser veterinario o secretaria.');
            return self::FAILURE;
        }

        $admin = DB::table('usuarios')
            ->where('rol', 'administrador')
            ->orderBy('id_usuario')
            ->first();

        if (! $admin) {
            $this->error('No existe un administrador. Ejecuta primero el seeder.');
            return self::FAILURE;
        }

        $prefijo = $prefijos[$rol];

        $ultimo = DB::table('codigos_acceso')
            ->where('codigo', 'like', $prefijo . '%')
            ->pluck('codigo')
            ->map(fn ($c) => (int) substr($c, strlen($prefijo)))
            ->max() ?? 0;

        $codigo = $prefijo . str_pad((string) ($ultimo + 1), 3, '0', STR_PAD_LEFT);

        DB::table('codigos_acceso')->insert([
            'codigo' => $codigo,
            'rol_asignado' => $rol,
            'usado' => 0,
            'fecha_generacion' => now(),
            'id_administrador' => $admin->id_usuario,
        ]);

        $this->info("Código generado: {$codigo} (rol: {$rol})");

        return self::SUCCESS;
    }
}
