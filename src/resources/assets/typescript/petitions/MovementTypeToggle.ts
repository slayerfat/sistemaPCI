/// <reference path="../../../../../typings/tsd.d.ts" />

module Petition {
    export class MovementTypeToggle {

        /**
         * El id del modelo
         */
        public id:number;

        /**
         * El url a donde apunta el ajax
         */
        public url:string;

        /**
         * El metodo que ajax necesita
         * @type {string}
         */
        private _method = 'POST';

        /**
         * El modelo que representa lo que llega del servidor
         */
        private _model = {
            data: {},
            ingress: null,
        };

        /**
         * Si esta instancia posee el id y el url de destino,
         * procede a ejecutar el ajax necesario.
         * @param id
         * @param url
         */
        constructor(id:number = null, url:string = null) {
            this.id = id;
            this.url = url;

            if (this.id && this.url) {
                this.getModel();
                this.changeInputs();
            }
        }

        /**
         * Basicamente debemos asegurarnos que tengamos el
         * token al momento de hacer la peticion ajax.
         * @private
         */
        private _checkToken():void {
            var $input = $('input[name="_token"]');

            if ($input.attr('value')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $input.attr('value')
                    }
                });
            }
        }

        /**
         * Busca en el API el tipo de stock relacionado a
         * la selecccion y chequea que el input sea valido.
         * @returns {Petition.MovementTypeToggle}
         */
        public getModel():MovementTypeToggle {
            this._checkToken();
            var self = this;

            var request = $.ajax({
                method: this._method,
                url: this.url,
                data: {
                    id: this.id
                },
                dataType: "json"
            });

            request.done(function (data) {
                if (data.status == true) {
                    self._model.data = data.model;
                    self._model.ingress = data.ingress;
                    self.changeInputs();
                } else if (data.status == false) {
                    console.log(data);
                } else {
                    console.log(data);
                }
            });

            request.fail(function (data) {
                console.log(data);
            });

            return this;
        }

        /**
         * Cambia el input de algun item sabiendo el stock y el tipo de movimiento.
         * @returns {Petition.MovementTypeToggle}
         */
        public changeInputs():MovementTypeToggle {
            var $element = $('.model-number-input');

            if ($element.length < 1) {
                return this;
            }

            if (this.isModelIngress()) {
                $element.attr('min', 1).attr('max', null);

                return this;
            }

            // debemos chequear los inputs porque es salida
            this.checkInputValue($element);
            $element.attr('min', 1).attr('max', $element.val());

            return this;
        }

        /**
         * Nos interesa saber si los elementos son validos en cuanto su
         * stock debido a que el usuario puede cambiar el tipo de
         * entrada del pedido o nota, debemos chequear que el
         * stock sea apropiado para entrada o salida.
         * @param $element
         */
        private checkInputValue($element:JQuery):void {
            $element.each(function (key, HTMLElement) {
                var $input = $(HTMLElement);

                if ($input.data('stock-plain') === undefined) {
                    return console.error('No se conoce el stock del articulo para continuar.')
                }

                // chequeamos que el stock no sea 0
                if ($input.data('stock-plain') <= 0) {
                    var html = '<label for="itemBag" class="control-label col-sm-8">' +
                        'El Item no se encuentra en existencia.' +
                        '</label>';

                    $input.closest('.itemBag-item').fadeOut(250, function () {
                        $(this).html(html);
                        $(this).fadeIn();
                        // espera 10 segundo y activa la animacion
                        $(this).animate({opacity: 1}, 10000, 'linear', function () {
                            $(this).animate({opacity: 0}, 2000, 'linear', function () {
                                $(this).remove();
                            });
                        });
                    });
                }
            });
        }

        /**
         * Nos interesa saber si el modelo es de tipo entrada o salida
         * @returns {boolean}
         */
        public isModelIngress():boolean {
            return this._model.ingress === true;
        }

        /**
         * Nos interesa saber si el modelo es de tipo entrada o salida.
         * @returns {boolean}
         */
        public isModelEgress():boolean {
            return !this.isModelIngress();
        }
    }
}
