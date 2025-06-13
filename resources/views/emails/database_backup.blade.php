@component('mail::message')
# Weekly Incremental Database Backup

**Backup Details:**
- Date: {{ now()->format('Y-m-d H:i:s') }}
- Tables Modified: {{ count($tables) }}
- Tables Included: {{ implode(', ', $tables) }}
- File Size: {{ round(filesize($filepath) / 1024 / 1024, 2) }} MB

@component('mail::button', ['url' => config('app.url')])
Visit Application
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent