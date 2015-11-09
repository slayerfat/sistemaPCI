/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms {
    export class ToggleComments {

        constructor(public $element:JQuery) {
            this.toggle();
        }

        /**
         * Como los comentarios llegan sucios, debemos limpiarlos
         * cuando estamos creando un nuevo formulario (pedido/notas, etc).
         */
        public toggle():void {
            var val = this.$element.val();

            if ($('meta[name="form-data"]').data('editing')) return;

            if (val.length > 1) {
                this.$element
                    .val('')
                    .prop('placeholder', 'Introduzca un comentario.');
            }
        }
    }
}
