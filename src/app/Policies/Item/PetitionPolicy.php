<?php namespace PCI\Policies\Item;

use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Mamarrachismo\Converter\StockTypeConverter;
use PCI\Models\Petition;
use PCI\Models\User;

/**
 * Class PetitionPolicy
 *
 * @package PCI\Policies
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionPolicy
{

    /**
     * @param \PCI\Models\User $user
     * @param \PCI\Models\Petition $petition
     * @return bool
     */
    public function create(User $user, Petition $petition)
    {
        if (!$petition instanceof Petition) {
            throw new \LogicException;
        }

        return $user->isUser() || $user->isAdmin();
    }

    /**
     * @param \PCI\Models\User                               $user
     * @param \PCI\Models\Petition                           $petition
     * @param StockTypeConverterInterface|StockTypeConverter $converter
     * @param int                                            $amount
     * @param int                                            $type
     * @return bool
     */
    public function addItem(
        User $user,
        Petition $petition,
        StockTypeConverterInterface $converter,
        $amount,
        $type
    ) {
        if (!$petition) {
            throw new \LogicException;
        }

        $item = $converter->getItem();

        if (!$converter->isConvertible()) {
            return $item->stock_type_id == $type;
        }

        $converted = $converter->convert($type, $amount);

        if ($user->isUser() || $user->isAdmin()) {
            return $item->stock >= $converted && $converted > 0;
        }

        return false;
    }
}
