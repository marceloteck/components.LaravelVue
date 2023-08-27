@php
 echo   HtmlHelper::htmlResources([
        ('https://sb-ui-kit-pro.startbootstrap.com/css/styles.css'),
        ('https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css'),
        ('https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css'),
        HtmlHelper::mix_version('/vendor/assets/css/styles.css'),
]);
@endphp