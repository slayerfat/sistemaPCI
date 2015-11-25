<script type="text/php">
    if ( isset($pdf) ) {
        $width = 36;
        $height = $pdf->get_height() - 36;
        $generated = e("Reporte generado: " . Date::now() . " por "
            . Auth::user()->name . " (" . Auth::user()->email . ")");
        $font = Font_Metrics::get_font("helvetica", "bold");
        $pdf->page_text($width, $height, "$generated, Pagina: {PAGE_NUM} of {PAGE_COUNT}", $font, 9);
    }
</script>
