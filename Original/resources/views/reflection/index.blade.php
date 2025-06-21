<!-- resources/views/reflection/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reflection Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="container">
                    <div class="header">
                        <h1 class="font-bold text-2xl mb-4">Student Reflection</h1>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="reflection mt-6">
                        @foreach($reflections as $reflection)
                            <div class="reflection-item">
                                <p>{{ $reflection->reflection }}</p>
                                <div class="action-btns">
                                    <button class="edit-btn bg-yellow-500 text-white py-1 px-3 rounded-lg" onclick="populateEdit({{ $reflection->id }}, '{{ $reflection->reflection }}')">Edit</button>
                                    <form action="{{ route('reflection.destroy', $reflection->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-btn bg-red-500 text-white py-1 px-3 rounded-lg">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
