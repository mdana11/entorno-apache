<h1>Your Environments</h1>
<ul>
    @foreach($environments as $environment)
        <li>
            <a href="{{ route('environments.show', $environment) }}">{{ $environment->name }}</a>
            <ul>
                @foreach($environment->tasks as $task)
                    <li>{{ $task->name }} - {{ $task->status }}</li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
