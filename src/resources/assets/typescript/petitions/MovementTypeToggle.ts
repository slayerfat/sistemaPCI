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

        constructor(id:number = null, url:string = null) {
            this.id = id;
            this.url = url;

            if (this.id && this.url) {
                this.getModel();
            }
        }

        private _checkToken() {
            var $input = $('input[name="_token"]');

            if ($input.attr('value')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $input.attr('value')
                    }
                });
            }
        }

        public getModel(): void {
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
                } else if (data.status == false) {
                    console.log(data);
                } else {
                    console.log(data);
                }
            });

            request.fail(function (data) {
                console.log(data);
            });
        }

        public isModelIngress() {
            return this._model.ingress;
        }

        public isModelEgress() {
            return !this._model.ingress;
        }
    }
}
