/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms {
    export class AjaxSetup {
        constructor(public value:string) {
        }

        /**
         * Basicamente debemos asegurarnos que tengamos el
         * token al momento de hacer la peticion ajax.
         * @private
         */
        public setLaravelToken():void {
            if (this.value) {
                return $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': this.value
                    }
                });
            }

            throw new Error;
        }
    }
}
