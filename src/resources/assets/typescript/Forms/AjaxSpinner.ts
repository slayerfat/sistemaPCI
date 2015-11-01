/// <reference path="../../../../../typings/tsd.d.ts" />

module Forms {
    export class AjaxSpinner {
        private html = '<div class="col-xs-push-4 col-xs-4 text-center">' +
            '<i class="fa fa-spinner fa-spin fa-5x"></i>' +
            '</div>';

        private previousHTML:any|string;

        constructor(public $element:JQuery) {
        }

        public appendSpinner():AjaxSpinner {
            this.appendPrototype(this.html);

            return this;
        }

        public cleanSpinner():AjaxSpinner {
            this.$element.empty();

            return this;
        }

        public toggleSpinner():AjaxSpinner {
            this.$element.toggle();

            return this;
        }

        public changeSpinner(HTML:any|string):AjaxSpinner {
            this.previousHTML = HTML;
            this.appendPrototype(this.previousHTML);

            return this;
        }

        private appendPrototype(HTML:any|string):void {
            this.$element.fadeOut(250, function () {
                $('#itemBag').append(HTML).fadeIn(250);
            });
        }
    }
}
