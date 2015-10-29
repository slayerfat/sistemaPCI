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
        private _model:{
            data: {};
            ingress: boolean;
        };

        constructor(id:number = null, url:string = null) {
            this.id = id;
            this.url = url;
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
            var request = $.ajax({
                method: this._method,
                url: this.url,
                data: {},
                dataType: "json"
            });

            request.done(function (data) {
                alert(data);
            });

            request.fail(function (data) {
                console.log(data);
            });

            //$.ajax(this.url, {
            //    method: this._method,
            //    dataType: 'json',
            //    success: function (data) {
            //        alert(data);
            //    },
            //    fail: function (data) {
            //        console.log(data);
            //    }
            //});
            //$.ajax({
            //    url: this.url,
            //    method: this._method,
            //    dataType: 'json',
            //    success: function (data) {
            //        alert(data);
            //    },
            //    fail: function (data) {
            //        console.log(data);
            //    }
            //});
        }

        public test() {
            console.log(this.id + ' ' + this.url);
        }

        public isModelIngress() {
            return this._model.ingress;
        }

        public isModelEgress() {
            return !this._model.ingress;
        }
    }
}
