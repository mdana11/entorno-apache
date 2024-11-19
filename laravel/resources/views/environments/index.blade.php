<x-layout>
    <h1 class="text-3xl font-bold mb-8">List of Environments</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($environments as $environment)
            <a href="{{ route('environments.show', $environment) }}"
                class="block bg-white text-black rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 hover:scale-105">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $environment->name }}</h2>
                    <p class="text-sm text-gray-700">{{ $environment->description }}</p>
                </div>
            </a>
        @endforeach
    </div>
</x-layout>
