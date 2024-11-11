@php
    use App\Models\Report;
    /** @var Report $report */
@endphp

<div>
    <h1>MRASmus</h1>
    <p>Здравствуйте, {{ $report->project->user->name }}</p>
    <p>Вот резльутаты вашего отчета за {{ $report->created_at->toFormattedDateString() }}</p>
    <p>
        Уровень безопасности в компании: {{ $report->percent }}%
    </p>
</div>
