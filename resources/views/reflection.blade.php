
<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reflection Page') }}
        </h2>

        <link href="{{ asset('style.css') }}" rel="stylesheet">
<link href="{{ asset('style.css') }}" rel="stylesheet">

    </x-slot>

    <style>
       .animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Add a fun hover effect to buttons */
        .submit-btn:hover,
        .edit-btn:hover,
        .delete-btn:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
        .container {
            padding: 20px;
            border-radius: 8px;
        }
        .header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 2em;
            color: #333;
        }
        .form-group label {
            font-weight: 700;
            margin-bottom: 5px;
        }
        .form-group textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .buttons .submit-btn {
            background-color: #3182ce; /* Blue */
            color: white;
        }
        .reflection .reflection-item {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .reflection-item p {
            margin: 0;
            flex: 1;
        }
        .reflection-item .action-btns button {
            margin-left: 10px;
        }
        .action-btns .edit-btn {
            background-color: #f6ad55; /* Orange */
            color: white;
        }
        .action-btns .delete-btn {
            background-color: #e53e3e; /* Red */
            color: white;
        }
    </style>

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

                    <form id="reflection-form" action="{{ route('reflections.store') }}" method="POST">

                        @csrf
                        <div class="form-group mb-4">
                            <label for="reflection" class="block font-medium text-lg mb-2">Your Reflection:</label>
                            <textarea id="reflection" name="reflection" required class="w-full p-2 border rounded-lg"></textarea>
                        </div>
                        <div class="buttons flex justify-between flex-wrap gap-4">
                            <button type="submit" class="submit-btn bg-blue-500 text-white py-2 px-4 rounded-lg">Submit</button>
                        </div>
                    </form>

                    <div class="reflection mt-6">
                        @forelse($reflections as $reflection)
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
                        @empty
                            <p>No reflections found.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function populateEdit(id, text) {
            const reflectionTextarea = document.getElementById('reflection');
            reflectionTextarea.value = text;
            document.getElementById('reflection-form').action = `/reflection/${id}`;
            document.getElementById('reflection-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';
            document.querySelector('.submit-btn').textContent = 'Update';
        }
    </script>
</x-app-layout>
