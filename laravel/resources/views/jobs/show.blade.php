<x-layout>
    <x-page-heading>{{ $job->title }}</x-page-heading>

    <div class="job-details">
        <p>Employer ID: {{ $job->employer->user_id }}</p>
        <p>Authenticated User ID: {{ Auth::id() }}</p>
        <p><strong>Salary:</strong> {{ $job->salary }}</p>
        <p><strong>Location:</strong> {{ $job->location }}</p>
        <p><strong>Schedule:</strong> {{ $job->schedule }}</p>
        <p><strong>URL:</strong> <a href="{{ $job->url }}" target="_blank">{{ $job->url }}</a></p>
        <p><strong>Tags:</strong> {{ $job->tags->pluck('name')->implode(', ') }}</p>
        
        @if (Auth::id() === $job->employer->user_id)
            <x-forms.button :href="route('jobs.edit', $job)" class="mt-4">Edit Job</x-forms.button>
        @endif
    </div>
</x-layout>
