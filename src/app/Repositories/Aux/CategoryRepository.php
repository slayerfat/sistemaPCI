<?php namespace PCI\Repositories\Aux;

use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;

/**
 * Class CategoryRepository
 * @package PCI\Repositories\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class CategoryRepository extends AbstractAuxRepository implements CategoryRepositoryInterface
{

    /**
     * Elimina a este modelo del sistema.
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.cats.singular'));
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $results = $this->getPaginator();

        $variable = $this->generateViewPaginatorVariable($results, 'cats');

        return $variable;
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la vista.
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getShowViewVariables($id)
    {
        // necesitamos encontrar al modelo
        $cat = $this->getBySlugOrId($id);

        // para generar la variable a ser consumida
        // por alguna vista, dandole el alias (cats)
        $variable = $this->generateViewVariable($cat, 'cats');
        $variable->setDestView('cats.show');

        // regresamos la variable, no el modelo.
        return $variable;
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getCreateViewVariables()
    {
        $results = $this->generateViewVariable($this->newInstance(), 'cats');

        $results->setUsersGoal(trans('models.cats.create'));
        $results->setDestView('cats.store');

        return $results;
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la
     * vista con el proposito de Model Binding.
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getEditViewVariables($id)
    {
        $cat = $this->getBySlugOrId($id);

        return $this->generateViewVariable($cat, 'cats');
    }
}
