/// <reference path="../../../../../typings/tsd.d.ts" />
/// <reference path="../Petition/RelatedItems.ts" />

module Note
{
    import PetitionRelatedItems = Petition.RelatedItems;
    export class RelatedItems extends PetitionRelatedItems
    {

        /**
         * Necesario para determinar el stock correcto segun el tipo de formulario.
         *
         * @returns {number}
         */
        protected getValidStock():number {
            return this.stock.real;
        }

        /**
         * determina si los elementos relacionados con la fecha deben ser iniciados.
         *
         * @returns {boolean}
         */
        protected canAddDueDate(): boolean {
            return this.data.type.perishable;
        }

        /**
         * contiene el input de algun item junto a su mensaje de ayuda.
         *
         * @returns {string}
         */
        protected makeItemInput(): string {
            return '<div class="row itemBag-item" data-id="' + this.data.id + '">'
                + '<div class="col-xs-12">'
                + '<label for="itemBag" class="control-label col-sm-7">'
                + this.data.desc
                + '</label>'
                + '<div class="col-sm-2">' +
                '<input class="form-control model-number-input" ' +
                'name="items[' + this.randomId + '][' + this.data.id + '][amount]"' +
                'type="number" ' +
                'data-stock-plain="' + this.stock.plain + '"' +
                'data-stock-real="' + this.stock.real + '"' +
                'value="' + this.stock.real + '">' +
                '<span class="help-block">' + this.stock.formattedReal + ' en total.' + '</span>' +
                '</div>';
        }
    }
}
