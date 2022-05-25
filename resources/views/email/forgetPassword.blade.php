@component('mail::message')
    <h1>Forget Password Email</h1>

    You can reset password from bellow link:
@component('mail::button', ['url' => '/'])

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
