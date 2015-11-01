/// <reference path="../../../../../typings/tsd.d.ts" />
/// <reference path="MovementTypeToggle.ts"/>
/// <reference path="RelatedStockType.ts"/>

module Petition {
    export class RelatedItems {
        public data = {
            id: null,
            desc: '',
            quantity: null,
            stock_type_id: null
        };

        public selected = [];

        public checkSelected = {
            lastSelected: null,
            selected: null,
            didNotChange: null
        };

        public stock = {
            plain: '',
            formatted: ''
        };

        public setItem(data) {
            this.data = data;
            this.grabItemStock(this.data);
        }

        public grabItemStock(item) {
            var self = this;

            $.ajax({
                url: '/api/items/stock/' + item.id,
                dataType: 'json',
                async: false,
                success: function (data) {
                    self.setStock(data);
                }
            });
        }

        public addSelected(id) {
            this.selected.push(parseInt(id));
        }

        public removeSelected(id) {
            this.selected.splice(this.selected.indexOf(parseInt(id)), 1);
        }

        public setStock(stock) {
            this.stock = stock;
        }

        public alreadySelected() {
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
        public checkSelectedStock(status:boolean) {
            this.checkSelected.selected = status;
            if (this.checkSelected.lastSelected === this.checkSelected.selected && this.checkSelected.lastSelected !== null) {
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
        public appendItem(e, stockTypes:stockTypes, toggle:MovementTypeToggle):void {
            // iniciamos el objeto
            this.setItem(e.params.data);

            // si el item ya esta seleccionado o si el item fue rechazado previamente
            // y no cambio la condicion de rechazo, entonces regresamos
            // temprano. (el orden de la condicion IMPORTA)
            if (this.checkSelectedStock(toggle.isModelIngress()) && this.alreadySelected()) {
                return;
            }

            var $itemBag = $('#itemBag');

            // chequeamos que el stock no sea 0
            if (parseFloat(this.stock.plain) <= 0 && this.checkSelected.selected) {
                this.appendErrorMsg($itemBag);
            }

            this.appendCorrectItem(stockTypes, $itemBag, toggle);
        }

        private appendCorrectItem(stockTypes:stockTypes, $itemBag:JQuery, toggle:MovementTypeToggle):void {
            var self = this;
            // como esta mamarrachada es muy grande, la
            // segmentamos para que pueda ser mas facil de digerir
            var itemInput = '<div class="itemBag-item" data-id="' + this.data.id + '">'
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

            var options = '';

            // generamos las opciones que van dentro del select
            Object.keys(stockTypes.types).forEach(function (key) {
                stockTypes.types[key].id == self.data.stock_type_id
                    ? options += '<option value="' + stockTypes.types[key].id + '" selected="selected">' + stockTypes.types[key].desc + '</option>'
                    : options += '<option value="' + stockTypes.types[key].id + '">' + stockTypes.types[key].desc + '</option>';
            });

            // este select contiene los tipos de cantidad
            var select = '<div class="col-sm-3">  <div class="input-group">' +
                '<select class="form-control" name="stock-type-id-' +
                this.data.id + '">' + options + '</select>' +
                '<span class="input-group-addon itemBag-remove-item" ' +
                'data-id="' + this.data.id + '">' +
                '<i class="fa fa-times"></i></span>' +
                '</div>' +
                '</div>';

            $itemBag.append(itemInput + select);

            this.addSelected(this.data.id);
            toggle.changeInputs();
        }

        private appendErrorMsg($itemBag) {
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
    }
}
