<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutores', function (Blueprint $table) {
            $table->id('id_tutor');
            $table->string('nombre', 100);
            $table->string('telefono', 20)->nullable();
            $table->unique(['nombre', 'telefono']);
        });

        Schema::table('mascotas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tutor')->nullable()->after('fecha_nacimiento');
        });

        // Copia los tutores que ya existen dentro de mascotas
        $mascotas = DB::table('mascotas')->select('id_mascota', 'tutor', 'telefono_tutor')->get();

        foreach ($mascotas as $m) {
            $nombre = trim((string) $m->tutor);
            $telefono = ($m->telefono_tutor === null || trim($m->telefono_tutor) === '')
                ? null
                : trim($m->telefono_tutor);

            $consulta = DB::table('tutores')->where('nombre', $nombre);
            $telefono === null
                ? $consulta->whereNull('telefono')
                : $consulta->where('telefono', $telefono);
            $idTutor = $consulta->value('id_tutor');

            if (! $idTutor) {
                $idTutor = DB::table('tutores')->insertGetId(
                    ['nombre' => $nombre, 'telefono' => $telefono],
                    'id_tutor'
                );
            }

            DB::table('mascotas')
                ->where('id_mascota', $m->id_mascota)
                ->update(['id_tutor' => $idTutor]);
        }

        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('mascotas', function (Blueprint $table) {
                $table->foreign('id_tutor')->references('id_tutor')->on('tutores');
            });
        }

        Schema::table('mascotas', function (Blueprint $table) {
            $table->dropColumn(['tutor', 'telefono_tutor']);
        });
    }

    public function down(): void
    {
        Schema::table('mascotas', function (Blueprint $table) {
            $table->string('tutor')->nullable();
            $table->string('telefono_tutor')->nullable();
        });

        $mascotas = DB::table('mascotas')->select('id_mascota', 'id_tutor')->get();

        foreach ($mascotas as $m) {
            $t = DB::table('tutores')->where('id_tutor', $m->id_tutor)->first();
            if ($t) {
                DB::table('mascotas')
                    ->where('id_mascota', $m->id_mascota)
                    ->update(['tutor' => $t->nombre, 'telefono_tutor' => $t->telefono]);
            }
        }

        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('mascotas', function (Blueprint $table) {
                $table->dropForeign(['id_tutor']);
            });
        }

        Schema::table('mascotas', function (Blueprint $table) {
            $table->dropColumn('id_tutor');
        });

        Schema::dropIfExists('tutores');
    }
};

