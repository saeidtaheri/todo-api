@component('mail::message')
# Todo Reminder

Reminder for __{{$todo->title}}__

@component('mail::table')
|Title|Description|
|:-----:|:----:|
{{$todo->title}} | {{$todo->body}}

@endcomponent

{{ config('app.name') }}
@endcomponent
