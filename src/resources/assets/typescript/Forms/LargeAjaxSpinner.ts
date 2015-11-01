/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms {
    export class LargeAjaxSpinner {
        private largeHTML = '<div class="large-ajax-spinner">' +
            '<p>' +
            '<i class="fa fa-spinner fa-spin fa-5x"></i>' +
            '</p>' +
            '<p>Procesando…</p>' +
            '</div>';

        public $form:JQuery;

        constructor(public $element:JQuery) {
        }

        public appendLargeSpinner():Forms.LargeAjaxSpinner {
            this.$element.append(this.largeHTML);

            return this;
        }

        public showLargeSpinner():Forms.LargeAjaxSpinner {
            $('.large-ajax-spinner').addClass('is-ajax-spinner-loading');

            return this;
        }

        public removeLargeSpinner():Forms.LargeAjaxSpinner {
            $('.large-ajax-spinner').removeClass('is-ajax-spinner-loading');

            return this;
        }

        public onSubmit($newElement?:JQuery):Forms.LargeAjaxSpinner {
            this.$form = $newElement ? $newElement : $('#large-ajax-form');
            if (this.$form.length < 1) {
                throw new Error('El spinner necesita saber a que forma anclarse');
            }

            this.$form.on('submit', () => this.showLargeSpinner());

            return this;
        }
    }
}
