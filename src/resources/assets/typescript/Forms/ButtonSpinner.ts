/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms {
    export class ButtonSpinner {
        public sent:boolean;

        constructor(public $element:JQuery) {
        }

        public before(previousClass:string) {
            if (previousClass === undefined) {
                throw new Error('Se necesita la clase previa para continuar.');
            }

            this.$element
                .removeClass('btn-default')
                .addClass('btn-warning')
                .find('span').removeClass(previousClass)
                .addClass('fa-spinner fa-spin');
        }

        public complete() {
            this.$element
                .removeClass('btn-warning')
                .find('span')
                .removeClass('fa-spinner fa-spin');
        }

        public success() {
            this.$element
                .removeClass('btn-default')
                .addClass('btn-success')
                .find('span')
                .addClass('fa-check-circle');
        }

        public fail() {
            this.$element
                .removeClass('btn-default')
                .addClass('btn-danger')
                .find('span')
                .removeClass('*')
                .addClass('fa-times-circle');
        }
    }
}
