/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms {
    export class AjaxSetup {
        constructor(public $element:JQuery) {
        }

        /**
         * Basicamente debemos asegurarnos que tengamos el
         * token al momento de hacer la peticion ajax.
         * @private
         */
        public setLaravelToken():void {
            if (this.$element.attr('value')) {
                return $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': this.$element.attr('value')
                    }
                });
            }

            throw new Error;
        }
    }
}
