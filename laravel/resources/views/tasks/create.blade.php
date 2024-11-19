<x-layout>
    <x-page-heading>Create New Task</x-page-heading>

    <x-forms.form method="POST" action="/tasks">

        <x-forms.input label="Name" name="name" placeholder="Task Name" />
        <x-forms.input label="Description" name="description" placeholder="Task Description" />
        <x-forms.input label="Start Date" name="start_date" type="date" />
        <x-forms.input label="Deadline" name="deadline" type="date" />

        <!-- Aquí también puedes asignar usuarios en el momento de la creación de la tarea -->
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
            @foreach ($environments as $environment)
                <option value="{{ $environment->id }}">{{ $environment->name }}</option>
            @endforeach
        </x-forms.select>

        <x-forms.divider />

        <x-forms.button>Create Task</x-forms.button>

    </x-forms.form>
</x-layout>
