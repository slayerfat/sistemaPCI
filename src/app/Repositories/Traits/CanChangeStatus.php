<?php namespace PCI\Repositories\Traits;

/**
 * Trait CanChangeStatus
 *
 * @package PCI\Repositories\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait CanChangeStatus
{

    /**
     * Cambia el estado del pedido.
     *
     * @param int  $id
     * @param bool $status
     * @return bool
     */
    public function changeStatus($id, $status)
    {
        if (!is_bool($status) && !is_null($status)) {
            if ($status != 'true' && $status != 'false' && $status != 'null') {
                return false;
            }
        }

        $model         = $this->getById($id);
        $model->status = $status;

        return $model->save();
    }
}
