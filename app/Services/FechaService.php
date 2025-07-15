<?php
namespace App\Services;

use Carbon\Carbon;

class FechaService
{
    public function sumarDiasHabiles(Carbon $fechaInicio, int $diasHabiles): Carbon
    {
        $fecha = $fechaInicio->copy();
        $sumados = 0;

        while ($sumados < $diasHabiles) {
            $fecha->addDay();

            if (!in_array($fecha->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $sumados++;
            }
        }

        return $fecha;
    }

    public function esDiaHabil(Carbon $fecha): bool
    {
        return !in_array($fecha->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
    }
    public function obtenerFechaActual(): Carbon
    {
        return Carbon::now();
    }
    public function formatearFecha(Carbon $fecha, string $formato = 'Y-m-d'): string
    {
        return $fecha->format($formato);
    }
    public function restarDiasHabiles(Carbon $fechaInicio, int $diasHabiles): Carbon
    {
        $fecha = $fechaInicio->copy();
        $restados = 0;

        while ($restados < $diasHabiles) {
            $fecha->subDay();

            if (!in_array($fecha->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $restados++;
            }
        }

        return $fecha;
    }
    public function obtenerFechaFutura(int $dias): Carbon
    {
        return Carbon::now()->addDays($dias);
    }
    public function obtenerFechaPasada(int $dias): Carbon
    {
        return Carbon::now()->subDays($dias);
    }
    public function obtenerFechaConFormato(Carbon $fecha, string $formato = 'd/m/Y'): string
    {
        return $fecha->format($formato);
    }
    public function obtenerFechaHoraActual(): Carbon
    {
        return Carbon::now();
    }
    public function obtenerFechaHoraConFormato(Carbon $fecha, string $formato = 'Y-m-d H:i:s'): string
    {
        return $fecha->format($formato);
    }
    public function obtenerFechaInicioDelMes(Carbon $fecha): Carbon
    {
        return $fecha->startOfMonth();
    }
    public function obtenerFechaFinDelMes(Carbon $fecha): Carbon
    {
        return $fecha->endOfMonth();
    }


}
