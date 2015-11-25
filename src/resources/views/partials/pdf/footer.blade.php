<footer>
    <p>Reporte generado: {{ Date::now() }} por {{ Auth::user()->name }}
        ({{ Auth::user()->email }})</p>
</footer>
