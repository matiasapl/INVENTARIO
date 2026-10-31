<?php

namespace App\Services;

use App\Models\Registro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class InventoryAudit
{
    /**
     * Run an inventory mutation and persist its audit event atomically.
     *
     * @param  callable(?Model): Model  $mutation
     */
    public function mutate(string $action, ?Model $model, callable $mutation): Model
    {
        return DB::transaction(function () use ($action, $model, $mutation): Model {
            $before = $model?->exists ? $this->snapshot($model) : null;
            $changedModel = $mutation($model);

            if (! $changedModel instanceof Model || ! $changedModel->exists) {
                throw new RuntimeException('An inventory audit mutation must return a persisted model.');
            }

            $changedModel->refresh();

            $record = new Registro([
                'codigo' => $changedModel->getAttribute('codigo'),
                'nombre' => $changedModel->getAttribute('nombre')
                    ?? $changedModel->getAttribute('descripcion')
                    ?? class_basename($changedModel),
                'accion' => $action,
                'tipo' => 'Manual',
                'usuario' => Auth::id(),
                'operacion_id' => (string) Str::uuid(),
                'anterior' => $before,
                'nuevo' => $this->snapshot($changedModel),
            ]);

            if (! $record->save()) {
                throw new RuntimeException('The inventory audit event could not be persisted.');
            }

            return $changedModel;
        });
    }

    /** @return array<string, mixed> */
    private function snapshot(Model $model): array
    {
        $snapshot = $model->attributesToArray();

        unset($snapshot['usuario'], $snapshot['created_at'], $snapshot['updated_at']);

        return $snapshot;
    }
}
