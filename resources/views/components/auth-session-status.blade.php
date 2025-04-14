@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-lg text-white dark:text-white']) }}>
        {{ $status }}
    </div>
@endif
