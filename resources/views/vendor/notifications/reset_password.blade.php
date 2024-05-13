@component('mail::message')

Şifrenizi sıfırlamak için aşağıdaki butona tıklayınız.

@if(isset($details['url']))
@component('mail::button', ['url' => $details['url']])
Şifremi Sıfırla
@endcomponent
@endif

@endcomponent