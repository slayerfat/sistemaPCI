/// <reference path="../../../../../typings/tsd.d.ts" />

module Petition {
    export class stockTypes {
        /**
         * tipos es un array de objetos.
         */
        public types:Array<{}>;

        constructor() {
            this.checkApi();
        }

        public isEmpty() {
            return this.types.length === 0;
        }

        public isNotEmpty() {
            return !this.isEmpty();
        }

        public checkApi() {
            var self = this;
            // necesitamos los tipos de stock para generar el select
            $(function () {
                $.ajax({
                    url: '/api/tipos-cantidad',
                    dataType: 'json',
                    success: function (data) {
                        self.types = data;
                    },
                    error: function () {
                        console.error('No se pudo contactar al servidor, tipos de stock desconocidos.');
                    }
                });
            });
        }
    }
}
