<footer class="footer-center">
    <p class="footer-centered-text footer-jumbo">
        {{trans('defaults.appName')}}
    </p>

    <p class="footer-enlaces">
        <a href="/">Inicio</a>
        <a href="#">{{trans('models.petitions.plural')}}</a>
        <a href="#">{{trans('models.notes.plural')}}</a>
        <a href="{{route('items.index')}}">{{trans('models.items.plural')}}</a>
    </p>

    <p class="footer-centered-text footer-authors">
        <a href="https://github.com/slayerfat">slayerfat</a> © 2015
    </p>

    <p class="footer-centered-text footer-authors">
        <a href="{{route('status')}}">status</a>
    </p>

    <p class="text-center">
        <a href="https://github.com/slayerfat/sistemaPCI"
           data-toggle="tooltip"
           title="Ver codigo fuente"
            >
            <i class="fa fa-2x fa-github"></i>
        </a>
    </p>
</footer>
