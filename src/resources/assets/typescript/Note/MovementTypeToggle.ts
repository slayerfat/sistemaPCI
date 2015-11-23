/// <reference path="../../../../../typings/tsd.d.ts" />
/// <reference path="../Petition/MovementTypeToggle.ts" />

module Note
{
    import PetitionToggle = Petition.MovementTypeToggle;
    export class MovementTypeToggle extends PetitionToggle
    {

        /**
         * Identifica cual es el stock del articulo
         * para saber si este esta o no en existencia.
         *
         * @param $input
         */
        protected getOriginalStock($input: JQuery): any {
            var stock = $input.data('stock-real');

            if (stock === undefined) {
                throw new Error('No se conoce el stock del articulo para continuar.')
            }

            return stock;
        }
    }
}
