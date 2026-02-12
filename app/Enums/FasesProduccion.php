<?php

namespace App\Enums;

enum FasesProduccion: string
{
    case TEJEDORA = 'tejedora';
    case HILVANADO = 'hilvanado';
    case PLANCHADO = 'planchado';
    case CORTE = 'corte';
    case CONFECCION = 'confeccion';
    case DESHILADO = 'deshilado';
    case PLANCHA_FINAL = 'plancha_final';
    case CALIDAD = 'calidad';
    case EMBALAJE = 'embalaje';
    case CONTEO_FINAL = 'conteo_final';
    case DISTRIBUCION = 'distribucion';

    /**
     * Orden lógico del flujo
     */
    public static function orden(): array
    {
        return [
            self::TEJEDORA,
            self::HILVANADO,
            self::PLANCHADO,
            self::CORTE,
            self::CONFECCION,
            self::DESHILADO,
            self::PLANCHA_FINAL,
            self::CALIDAD,
            self::EMBALAJE,
            self::CONTEO_FINAL,
            self::DISTRIBUCION,
        ];
    }

    /**
     * Nombre legible para UI
     */
    public function label(): string
    {
        return match ($this) {
            self::TEJEDORA => 'Tejedora',
            self::HILVANADO => 'Hilvanado',
            self::PLANCHADO => 'Planchado',
            self::CORTE => 'Corte',
            self::CONFECCION => 'Confección',
            self::DESHILADO => 'Deshilado',
            self::PLANCHA_FINAL => 'Plancha Final',
            self::CALIDAD => 'Control de Calidad',
            self::EMBALAJE => 'Embalaje',
            self::CONTEO_FINAL => 'Conteo Final',
            self::DISTRIBUCION => 'Distribución',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TEJEDORA => 'blue',
            self::HILVANADO => 'indigo',
            self::PLANCHADO => 'purple',
            self::CORTE => 'orange',
            self::CONFECCION => 'pink',
            self::DESHILADO => 'red',
            self::PLANCHA_FINAL => 'yellow',
            self::CALIDAD => 'green',
            self::EMBALAJE => 'teal',
            self::CONTEO_FINAL => 'cyan',
            self::DISTRIBUCION => 'gray',
        };
    }

}
