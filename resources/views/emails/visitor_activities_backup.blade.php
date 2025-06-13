@component('mail::message')
# Weekly Visitor Activities Backup

Attached is the weekly backup of visitor activities. The following actions have been performed:

- All visitor activities have been exported to CSV
- Records older than 7 days have been purged from the database

**Backup Date:** {{ now()->format('Y-m-d H:i:s') }}

@component('mail::button', ['url' => config('app.url')])
Visit Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent