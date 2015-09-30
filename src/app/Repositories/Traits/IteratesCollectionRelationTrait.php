<?php namespace PCI\Repositories\Traits;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait IteratesCollectionRelationTrait
 * @package PCI\Repositories\Traits
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait IteratesCollectionRelationTrait
{

    /**
     * Devuelve un array asociativo con los elementos
     * y sus subelementos.
     * Basicamente deberia ser un array con
     * ['desc tal' => ['id' => 'desc tal de la otra relacion']].
     * @param \Illuminate\Database\Eloquent\Collection $models
     * @param string $relationship la relacion a manipular
     * @param string $parentField el nombre del campo del modelp
     * @param string $relationField el nombre del campo de la relacion
     * @return array|\array[]
     */
    protected function createCollectionRelationArray(
        Collection $models,
        $relationship,
        $parentField = 'desc',
        $relationField = 'desc'
    ) {
        $array = [];

        if ($models->isEmpty()) {
            return $array;
        }

        foreach ($models as $model) {
            foreach ($model->$relationship as $relation) {
                $array[$model->$parentField][$relation->id] = $relation->$relationField;
            }
        }

        return $array;
    }
}
