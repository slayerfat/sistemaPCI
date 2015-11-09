/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms
{
    export class Message
    {

        /**
         * la representacion del elemento por defecto
         * @type {string}
         */
        private HTML: string;

        private id: string;

        /**
         * algun elemento ya existente
         */
        public $element: JQuery;

        constructor($element?: JQuery) {
            var id    = Math.random().toString(8).slice(2);
            this.id   = '#' + id;
            this.HTML = '<div ' + 'id="' + id + '"' +
                'class="message-generic alert" ' +
                'style="display:none;">' +
                '<p></p>' +
                '</div>';

            if ($element === undefined || $element.length < 1) {
                $('body').prepend(this.HTML);
                $element = $(this.id);
            }

            this.$element = $element;
        }

        /**
         * Creamos un mensaje que flotara en
         * la vista con la informacion suministrada.
         * @param msg el mensaje para el usuario
         * @param classes las clases para el css
         * @param timer
         * @param func
         */
        createMessage(
            msg: string,
            classes: string,
            timer = 10000,
            func?: (any: any) => any
        ): void {
            this.$element
                .removeClass('alert alert-danger alert-success')
                .addClass(classes)
                .show()
                .children()
                .html(msg);

            // ejecuta la funcion que llega, si existe
            if (func) {
                this.$element.children().children().on("click", (evt) => func(evt));
            }

            setTimeout(() => this.toggleMessage(), timer);
        }

        /**
         * cambia el estado del mensaje ya creado.
         */
        toggleMessage(): void {
            this.$element.fadeToggle(1000, function () {
                $(this).children().empty();
            });
        }
    }
}
