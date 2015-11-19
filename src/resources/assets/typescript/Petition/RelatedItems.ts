/// <reference path="../../../../../typings/tsd.d.ts" />
/// <reference path="MovementTypeToggle.ts"/>
/// <reference path="RelatedStockType.ts"/>
/// <reference path="../Models/Interfaces/Item/Item.ts"/>

module Petition
{
    import Item = Models.Interfaces.Item;
    export class RelatedItems
    {
        /**
         * La informacion relacionada con UN item en
         * particular (el que se esta manipulando)
         */
        public data: Item;

        /**
         * El arreglo de items en algun pedido/nota.
         *
         * @type {Array}
         */
        private items: Item[] = [];

        /**
         * el arreglo de Ids de los items seleccionados.
         */
        public selected: number[];

        /**
         * Usado para determinar si algun tipo de movimiento fue cambiado o no
         */
        public checkSelected: {
            lastSelected: boolean,
            selected: boolean,
            didNotChange: boolean
        };

        /**
         * La informacion del stock del item siendo manipulado
         */
        public stock: {
            plain: number,
            formatted: string
            real: number
            formattedReal: string
        };

        /**
         * Tiene el proposito de ser el identificador unico para
         * cuando se pretenda ducplicar algun input para
         * cambiar las fechas de vencimiento.
         */
        protected randomId: number;

        constructor() {
            this.data = {
                id: null,
                desc: '',
                quantity: null,
                stock_type_id: null,
                type: {
                    id: null,
                    desc: null,
                    slug: null,
                    perishable: null
                }
            };

            this.checkSelected = {
                lastSelected: null,
                selected: null,
                didNotChange: null
            };

            this.selected = [];

            this.setRandomId();
        }

        private setRandomId(number?: number): void {
            this.randomId = number || Math.ceil(Math.random() * 100000);
        }

        /**
         * Añade algun item a la data y busca su stock.
         * @param data
         */
        public setItem(data: Item): Petition.RelatedItems {
            this.data = data;
            this.items.push(data);
            this.grabItemStock(this.data);

            return this;
        }

        /**
         * busca y regresa algun item con el id especificado.
         * @param id
         * @returns Item|null
         */
        private findItemById(id: number): Item {
            var element = null;

            this.items.forEach((item, key) => {
                if (item.id == id) {
                    return element = this.items[key];
                }
            });

            return element;
        }

        /**
         * Llama al api para determinar el stock de un Item cualquiera
         * @param item
         */
        public grabItemStock(item): Petition.RelatedItems {
            $.ajax({
                url: '/api/items/stock/' + item.id,
                dataType: 'json',
                async: false,
                success: (data) => {
                    this.setStock(data);
                }
            });

            return this;
        }

        /**
         * Añade el id de algun item para saber si esta seleccionado o no
         * @param id
         */
        public addSelected(id): Petition.RelatedItems {
            this.selected.push(parseInt(id));

            return this;
        }

        /**
         * Remueve el id de algun item de los que estan seleccionados
         * @param id
         */
        public removeSelected(id): Petition.RelatedItems {
            this.selected.splice(this.selected.indexOf(parseInt(id)), 1);

            return this;
        }

        /**
         * Remueve TODOS los items seleccionados
         */
        public resetSelected(): Petition.RelatedItems {
            this.selected = [];

            return this;
        }

        /**
         * Actualiza el stock de un item cualquiera
         * @param stock
         */
        public setStock(stock): Petition.RelatedItems {
            this.stock = stock;

            return this;
        }

        /**
         * chequea que el item seleccionado exista o no en el grupo de items.
         * @returns {boolean}
         */
        public alreadySelected(): boolean {
            var selected = false;

            this.selected.forEach(function (key) {
                if (key == this.data.id) selected = true;
            }.bind(this));

            return selected;
        }

        /**
         * chequea que el elemento seleccionado no haya cambiado.
         * @returns {boolean}
         */
        public selectedStockChange(status: boolean): boolean {
            this.checkElement(status);

            this.checkSelected.selected = status;
            if (this.checkSelected.lastSelected === this.checkSelected.selected
                && this.checkSelected.lastSelected !== null
            )
            {
                return this.checkSelected.didNotChange = true;
            }

            this.checkSelected.lastSelected = this.checkSelected.selected;
            return this.checkSelected.didNotChange = false;
        }

        /**
         * Añade algun item al HTML existente en el formulario y
         * genera mensaje de error si este no tiene stock.
         * @param e
         * @param stockTypes
         * @param toggle
         */
        public appendItem(
            e,
            stockTypes: stockTypes,
            toggle: MovementTypeToggle
        ): Petition.RelatedItems {
            try {
                this.checkElement(e).checkElement(stockTypes).checkElement(toggle);
            } catch (e) {
                console.error('Parametros incompletos!');
                return this;
            }

            // iniciamos el objeto
            this.setItem(e.params.data);

            if (this.alreadySelected()) {
                return this;
            }

            try {
                this.continueAppending(stockTypes, toggle);
            } catch (e) {
                this.appendStockTypeError($('#itemBag'), stockTypes, toggle);
                console.error(e.message);
            }

            return this;
        }

        private continueAppending(
            stockTypes: stockTypes,
            toggle: MovementTypeToggle
        ): void {
            var $itemBag = $('#itemBag');
            var stock    = this.getValidStock();

            // chequeamos que el stock no sea 0
            if (stock <= 0 && toggle.isModelEgress()) {
                return this.appendErrorMsg($itemBag);
            }

            if (stockTypes.isEmpty()) {
                stockTypes.checkApi();
                throw new Error('tipos de stock vacios, no se puede continuar');
            }

            this.appendCorrectItem(stockTypes, $itemBag, toggle);

            this.addSelected(this.data.id);
        }

        /**
         * Necesario para determinar el stock correcto segun el tipo de formulario.
         *
         * @returns {number}
         */
        protected getValidStock(): number {
            return this.stock.plain;
        }

        /**
         * Añade un elemento con un item, este tiene select, desc y entrada de numeros.
         * @param stockTypes
         * @param $itemBag
         * @param toggle
         */
        private appendCorrectItem(
            stockTypes: stockTypes,
            $itemBag: JQuery,
            toggle: MovementTypeToggle
        ): void {
            // como esta mamarrachada es muy grande, la
            // segmentamos para que pueda ser mas facil de digerir
            var itemInput = this.makeItemInput();
            var options   = this.makeSelectOptions(stockTypes);
            var classId   = 'item-due-date-' + this.data.id;
            var select    = this.makeSelect(options, classId, toggle);

            $itemBag.append(itemInput + select);
            toggle.changeInputs();
            this.setRandomId();

            $('.itemBag-remove-item').click((evt: JQueryEventObject) => {
                this.removeItem($(evt.target))
            });

            if (this.canAddDueDate()) {
                if (toggle.isModelIngress()) {
                    this.makeDueDateButton($itemBag, stockTypes, toggle);
                }

                $('.' + classId).datepicker({
                    language: 'es',
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    autoclose: true,
                    startDate: "-10d"
                });
            }
        }

        /**
         * Remueve el input y sus elementos relacionados del formulario donde
         * se encuentra y adiconalmente elimina el boton
         * @param $element
         */
        private removeItem($element: JQuery): void {
            var $item   = $element.closest('.itemBag-item');
            var id      = $item.data('id');
            var $button = $('button[data-item-id="' + id + '"]');

            $item.fadeToggle(() => {
                if ($button !== undefined) {
                    $button.fadeOut(function () {
                        $button.closest('div').remove();
                    });
                }

                this.removeSelected(id);
                $item.remove()
            });
        }

        /**
         * determina si los elementos relacionados con la fecha deben ser iniciados.
         *
         * @returns {boolean}
         */
        protected canAddDueDate(): boolean {
            return null;
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
                'value="' + this.stock.plain + '">' +
                '<span class="help-block">' + this.stock.formatted + ' en total.' + '</span>' +
                '</div>';
        }

        /**
         * Determina cual es la opcion correcta que ira en el select.
         *
         * @param stockTypes
         * @returns {string}
         */
        private makeSelectOptions(stockTypes: stockTypes): string {
            var options = '';

            Object.keys(stockTypes.types).forEach((key) => {
                stockTypes.types[key].id == this.data.stock_type_id
                    ? options += '<option value="' + stockTypes.types[key].id + '" selected="selected">' + stockTypes.types[key].desc + '</option>'
                    : options += '<option value="' + stockTypes.types[key].id + '">' + stockTypes.types[key].desc + '</option>';
            });

            return options;
        }

        /**
         * Elemento que select contiene los tipos de
         * cantidad y fecha de vencimiento.
         *
         * @param options
         * @param id
         * @param toggle
         * @returns {string}
         */
        private makeSelect(options, id, toggle): string {
            var dateInput = '<input class="form-control help-block ' + id + '" ' +
                'name="items[' + this.randomId + '][' + this.data.id + '][due]"' +
                'placeholder="Fecha de Vto.">';

            var string = '<div class="col-sm-3">  <div class="input-group">' +
                '<select class="form-control" name="items[' + this.randomId + '][' + this.data.id + '][stock_type_id]">' +
                options + '</select>' +
                '<span class="input-group-addon itemBag-remove-item" ' +
                'data-id="' + this.data.id + '">' +
                '<i class="fa fa-times"></i></span>' +
                '</div>';

            // necesitamos saber si el item es perecedero
            // para poner o no la seleccion de fecha de vencimiento.
            if (this.canAddDueDate()) {
                if (toggle.isModelIngress()) {
                    return string + dateInput + '</div></div>';
                }

                return string + '</div></div>';
            }

            // div 1 es itemBag, div 2 es col-xs-12
            // HTML ES DIVERTIDO Y MUY CHEVERE Y EMOCIONANTE Y SUPER MODERNO.
            return string + '</div></div>';
        }

        /**
         * Genera el boton necesario para clonar elementos
         * con fechas diferentes pero del mismo item.
         *
         * @param $itemBag
         * @param stockTypes
         * @param toggle
         */
        private makeDueDateButton(
            $itemBag: JQuery,
            stockTypes: stockTypes,
            toggle: MovementTypeToggle
        ): void {
            // .due-button tiene css extra, no alterar.
            // HTML + CSS ES CHEVERE Y EMOCIONANTE Y DIVERTIDO Y GENIAL.
            var button = '<div class="col-sm-10 col-sm-push-2">' +
                '<button class="btn btn-success btn-block due-button" ' +
                'data-item-id="' + this.data.id + '">' +
                'Añadir ' + this.data.desc + ' con otra fecha' +
                '</button></div>';

            $itemBag.append(button);

            $('.due-button').click((evt: JQueryEventObject) => {
                evt.preventDefault();
                $(evt.target).closest('div').fadeOut(250, () => {
                    $(evt.target).closest('div').remove();
                    this.removeSelected($(evt.target).data('item-id'));
                    this.data = this.findItemById($(evt.target).data('item-id'));
                    this.appendCorrectItem(stockTypes, $itemBag, toggle);
                });
            });
        }

        /**
         * Genera un elemento con un mensaje de error que se oculta automaticamente.
         * @param $itemBag
         */
        private appendErrorMsg($itemBag): void {
            var $error = $('<label for="itemBag" class="control-label col-sm-8">' +
                this.data.desc + ' no se encuentra en existencia.' +
                '</label>');

            $itemBag.append($error);

            // espera 10 segundo y activa la animacion
            $error.animate({opacity: 1}, 10000, 'linear', function () {
                $error.animate({opacity: 0}, 2000, 'linear', function () {
                    $error.remove();
                });
            });
        }

        /**
         * Genera un elemento con un mensaje de error que se oculta automaticamente.
         * @param $itemBag
         * @param stockTypes
         * @param toggle
         * @param func version mamarracha de una funcion anonima
         */
        public appendStockTypeError(
            $itemBag: JQuery,
            stockTypes: stockTypes,
            toggle: MovementTypeToggle,
            func?: (any: any) => any|void
        ): Petition.RelatedItems {
            var $error  = $('<label for="itemBag" class="control-label col-sm-8">' +
                'Error inesperado del servidor! ' +
                '<button class ="btn btn-warning" id="stock-type-error">' +
                'Intente nuevamente ' + '<i class="fa fa-undo"></i>' +
                '</button>' +
                '</label>');

            $itemBag.empty().append($error);
            var $target = $('#stock-type-error');

            if (func) {
                $target.on("click", (evt) => func(evt));
                return this;
            }

            $target.on("click", (evt) => this.removeStockTypeError(evt, stockTypes, toggle));
            return this;
        }

        /**
         * elimina el mensaje ya puesto e intenta añadir items nuevamente.
         * @param event
         * @param types
         * @param toggle
         */
        private removeStockTypeError(
            event: JQueryEventObject,
            types: stockTypes,
            toggle: MovementTypeToggle
        ): void {
            event.preventDefault();
            $(event.target).parent().empty();

            this.continueAppending(types, toggle);
        }

        /**
         * chequea que los parametros no sean undefined
         * @param element
         * @returns {Petition.RelatedItems}
         */
        private checkElement(element: any): Petition.RelatedItems {
            if (element === undefined) {
                throw new Error;
            }

            return this;
        }
    }
}
