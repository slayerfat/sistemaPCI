<?php

/**
 * Por ahora esta interface solo sirve como amalgama de las distintas
 * interfaces que el repositorio utliza.
 * Se hizo de esta forma porque cuando se solicita la implementacion
 * de un repositorio se debe dar el que corresponde, es
 * decir, si algun solicita la interfaz de arepas,
 * hay que darle la implementacion de arepas.
 * Pudiera ser mejorado.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */

namespace PCI\Repositories\Interfaces\Aux;

use PCI\Repositories\Interfaces\GetBySlugOrIdInterface;
use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\Viewable\ViewableInterface;

interface GenderRepositoryInterface extends ModelRepositoryInterface, ViewableInterface, GetBySlugOrIdInterface
{

}
