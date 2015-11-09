/// <reference path="../../../../../typings/tsd.d.ts" />
/// <reference path="MovementTypeToggle.ts"/>
/// <reference path="RelatedStockType.ts"/>
/// <reference path="../Models/Interfaces/Item/Item.ts"/>

module Petition {
    import Item = Models.Interfaces.Item;
    export class RelatedItems {
        /**
         * La informacion relacionada con UN item en
         * particular (el que se esta manipulando)
         */
        public data: Item;

        /**
         * el arreglo de Ids de los items seleccionados.
         */
        public selected:number[];

        /**
         * Necesario para saber que tipo de
         * formulario esta asociado a esta clase.
         */
        public formType: string;

        /**
         * Usado para determinar si algun tipo de movimiento fue cambiado o no
         */
        public checkSelected:{
            lastSelected: boolean,
            selected: boolean,
            didNotChange: boolean
        };

        /**
         * La informacion del stock del item siendo manipulado
         */
        public stock:{
            plain: number,
            formatted: string
            real: number
            formattedReal: string
        };

        constructor(formType: string = null)
        {
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

            this.formType = formType;
        }

        /**
         * Añade algun item a la data y busca su stock.
         * @param data
         */
        public setItem(data):Petition.RelatedItems {
            this.data = data;
            this.grabItemStock(this.data);

            return this;
        }

        /**
         * Llama al api para determinar el stock de un Item cualquiera
         * @param item
         */
        public grabItemStock(item):Petition.RelatedItems {
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
        public addSelected(id):Petition.RelatedItems {
            this.selected.push(parseInt(id));

            return this;
        }

        /**
         * Remueve el id de algun item de los que estan seleccionados
         * @param id
         */
        public removeSelected(id):Petition.RelatedItems {
            this.selected.splice(this.selected.indexOf(parseInt(id)), 1);

            return this;
        }

        /**
         * Remueve TODOS los items seleccionados
         */
        public resetSelected():Petition.RelatedItems {
            this.selected = [];

            return this;
        }

        /**
         * Actualiza el stock de un item cualquiera
         * @param stock
         */
        public setStock(stock):Petition.RelatedItems {
            this.stock = stock;

            return this;
        }

        /**
         * chequea que el item seleccionado exista o no en el grupo de items.
         * @returns {boolean}
         */
        public alreadySelected():boolean {
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
        public selectedStockChange(status:boolean):boolean {
            this.checkElement(status);

            this.checkSelected.selected = status;
            if (this.checkSelected.lastSelected === this.checkSelected.selected
                && this.checkSelected.lastSelected !== null
            ) {
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
        public appendItem(e, stockTypes:stockTypes, toggle:MovementTypeToggle):Petition.RelatedItems {
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

        private continueAppending(stockTypes:stockTypes, toggle:MovementTypeToggle):void {
            var $itemBag = $('#itemBag');

            // chequeamos que el stock no sea 0
            if (this.stock.plain <= 0 && toggle.isModelEgress()) {
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
         * Añade un elemento con un item, este tiene select, desc y entrada de numeros.
         * @param stockTypes
         * @param $itemBag
         * @param toggle
         */
        private appendCorrectItem(stockTypes:stockTypes, $itemBag:JQuery, toggle:MovementTypeToggle):void {
            var self = this;
            // como esta mamarrachada es muy grande, la
            // segmentamos para que pueda ser mas facil de digerir
            var itemInput = this.makeItemInput();
            var options = this.makeSelectOptions(stockTypes, self);

            var id = 'item-due-date-' + this.data.id;
            var select = this.makeSelect(options, id);

            $itemBag.append(itemInput + select);
            toggle.changeInputs();

            if (this.canAddDueDate()) {
                $('#'+id).datepicker({
                    language: 'es',
                    format: 'yyyy-mm-dd',
                    todayHighlight: true
                });
            }
        }

        /**
         * determina si los elementos relacionados con la fecha deben ser iniciados.
         *
         * @returns {boolean}
         */
        private canAddDueDate(): boolean
        {
            if (this.formType === null || this.formType === undefined) {
                return false;
            }

            return this.data.type.perishable
                && this.formType.toLowerCase() == 'note';
        }

        /**
         * contiene el input de algun item junto a su mensaje de ayuda.
         *
         * @returns {string}
         */
        private makeItemInput(): string
        {
            return '<div class="itemBag-item" data-id="' + this.data.id + '">'
                + '<label for="itemBag" class="control-label col-sm-7">'
                + this.data.desc
                + '</label>'
                + '<div class="col-sm-2">' +
                '<input class="form-control model-number-input" ' +
                'name="item-id-' + this.data.id + '" ' +
                'type="number" ' +
                'data-stock-plain="' + this.stock.plain + '"' +
                'value="' + this.stock.plain + '">' +
                '<span class="help-block">' + this.stock.formatted + ' en total.' + '</span>' +
                '</div>';
        }

        /**
         * Determina cual es la opcion correcta que ira en el select.
         *
         * @param stockTypes
         * @param self
         * @returns {string}
         */
        private makeSelectOptions(stockTypes, self): string
        {
            var options = '';

            // generamos las opciones que van dentro del select
            Object.keys(stockTypes.types).forEach(function (key) {
                stockTypes.types[key].id == self.data.stock_type_id
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
         * @returns {string}
         */
        private makeSelect(options, id): string
        {
            var dateInput = '<input class="form-control help-block" ' +
                'name="due-date-value-' + this.data.id + '"' +
                'placeholder="Fecha de Vto."' +
                'id="' + id + '">';

            var string = '<div class="col-sm-3">  <div class="input-group">' +
                '<select class="form-control" name="stock-type-id-' +
                this.data.id + '">' + options + '</select>' +
                '<span class="input-group-addon itemBag-remove-item" ' +
                'data-id="' + this.data.id + '">' +
                '<i class="fa fa-times"></i></span>' +
                '</div>';

            // necesitamos saber si el item es perecedero
            // para poner o no la seleccion de fecha de vencimiento.
            if (this.canAddDueDate()) {
                return string + dateInput + '</div>';
            }

            return string + '</div>';
        }

        /**
         * Genera un elemento con un mensaje de error que se oculta automaticamente.
         * @param $itemBag
         */
        private appendErrorMsg($itemBag):void {
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
        public appendStockTypeError($itemBag:JQuery,
                                    stockTypes:stockTypes,
                                    toggle:MovementTypeToggle,
                                    func?:(any:any) => any|void):Petition.RelatedItems {
            var $error = $('<label for="itemBag" class="control-label col-sm-8">' +
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
        private removeStockTypeError(event:JQueryEventObject, types:stockTypes, toggle:MovementTypeToggle):void {
            event.preventDefault();
            $(event.target).parent().empty();

            this.continueAppending(types, toggle);
        }

        /**
         * chequea que los parametros no sean undefined
         * @param element
         * @returns {Petition.RelatedItems}
         */
        private checkElement(element:any):Petition.RelatedItems {
            if (element === undefined) {
                throw new Error;
            }

            return this;
        }
    }
}
