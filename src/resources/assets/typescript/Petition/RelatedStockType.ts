/// <reference path="../../../../../typings/tsd.d.ts" />

module Petition
{
    export class stockTypes
    {
        /**
         * tipos es un array de objetos.
         */
        public types: Array<{}>;

        constructor() {
            this.checkApi();
        }

        /**
         * Chequea que los tipos esten o no vacios
         * @returns {boolean}
         */
        public isEmpty(): boolean {
            if (this.types === undefined) {
                return true;
            }

            return this.types.length === 0;
        }

        /**
         * Chequea que los tipos esten o no vacios
         * @returns {boolean}
         */
        public isNotEmpty(): boolean {
            return !this.isEmpty();
        }

        /**
         * Chequea los tipos en el servidor
         */
        public checkApi(): void {
            // necesitamos los tipos de stock para generar el select
            $(() => {
                $.ajax({
                    url: '/api/tipos-cantidad',
                    dataType: 'json',
                    success: function (data) {
                        this.types = data;
                    },
                    error: function () {
                        throw new Error('No se pudo contactar al servidor, tipos de stock desconocidos.');
                    }
                });
            });
        }
    }
}
