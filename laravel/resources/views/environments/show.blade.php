<x-layout>
    <div class="max-w-4xl mx-auto p-6 bg-gray-800 rounded-lg shadow-lg">
        <!-- Título del entorno -->
        <h1 class="text-3xl font-bold text-center text-white mb-4">{{ $environment->name }}</h1>
        <p class="text-lg text-center text-gray-300 mb-6">{{ $environment->description }}</p>

        <!-- Contenedor para las cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Card para los usuarios -->
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Users in this environment</h2>
                <ul class="space-y-2">
                    @foreach($environment->users as $user)
                        <li class="flex items-center space-x-2 text-gray-300">
                            <span class="font-medium">{{ $user->name }}</span>
                            <span class="text-sm text-gray-400">({{ $user->pivot->role }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Card para las tareas -->
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Tasks</h2>
                <ul class="space-y-4">
                    @foreach($tasks as $task)
                        <li class="bg-gray-800 p-4 rounded-lg shadow-sm">
                            <h3 class="font-semibold text-white">{{ $task->name }} - <span class="text-gray-400">{{ $task->status }}</span></h3>
                            <ul class="mt-2 space-y-1">
                                @foreach($task->users as $user)
                                    <li class="text-sm text-gray-300">{{ $user->name }} ({{ $user->pivot->role }})</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>

                <!-- Botón para agregar una nueva tarea -->
                <button id="addTaskButton" class="mt-6 w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">Add Task</button>

                <!-- Formulario para crear una tarea (oculto por defecto) -->
                <div id="addTaskForm" class="mt-6 hidden bg-gray-700 text-white p-6 rounded-lg shadow-lg">
                    <x-forms.form method="POST" action="/tasks">
                        @csrf

                        <x-forms.input label="Name" name="name" placeholder="Task Name" />
                        <x-forms.input label="Description" name="description" placeholder="Task Description" />
                        <x-forms.input label="Start Date" name="start_date" type="date" />
                        <x-forms.input label="Deadline" name="deadline" type="date" />

                        <x-forms.select label="Assign Users" name="users[]" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-forms.select>

                        <x-forms.select label="Status" name="status">
                            <option value="pending">Pending</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </x-forms.select>

                        <x-forms.select label="Environment" name="environment_id">
                            <option value="{{ $environment->id }}" selected>{{ $environment->name }}</option>
                        </x-forms.select>

                        <x-forms.divider />

                        <x-forms.button>Create Task</x-forms.button>
                    </x-forms.form>
                </div>
            </div>
        </div>

        <!-- Formulario para agregar usuarios -->
        <div class="mt-8 bg-gray-700 p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-white mb-4">Add Users to this Environment</h3>
            <form action="{{ route('environments.addUsers', $environment) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <label for="user_ids" class="block text-lg text-gray-300">Select Users:</label>
                    <select name="user_ids[]" multiple class="w-full p-3 border text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">Add Users</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript para mostrar el formulario de crear tarea -->
    <script>
        document.getElementById('addTaskButton').addEventListener('click', function() {
            let form = document.getElementById('addTaskForm');
            form.classList.toggle('hidden');
        });
    </script>
</x-layout>
