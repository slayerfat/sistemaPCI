/// <reference path="../../../../../typings/tsd.d.ts" />

module Petition {
    export class stockTypes {
        public types = {};

        constructor() {
            this.checkApi();
        }

        public checkApi() {
            var self = this;
            // necesitamos los tipos de stock para generar el select
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
        }
    }
}
