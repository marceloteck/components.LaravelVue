@vite('resources/js/app.js')

@php
 echo   
 HtmlHelper::htmlResources([
        'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js',
        'https://sb-ui-kit-pro.startbootstrap.com/js/scripts.js',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js',
        'https://cdn.jsdelivr.net/npm/simple-datatables@latest',
        'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js',
        HtmlHelper::mix_version('/vendor/assets/js/scripts.js'),
], 'javascript');
@endphp
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}