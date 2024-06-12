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
                    <form id="reflection-form">
                        <div class="form-group mb-4">
                            <label for="reflection" class="block font-medium text-lg mb-2">Your Reflection:</label>
                            <textarea id="reflection" name="reflection" required class="w-full p-2 border rounded-lg"></textarea>
                        </div>
                        <div class="buttons flex justify-between flex-wrap gap-4">
                            <button type="button" class="add-btn bg-green-500 text-white py-2 px-4 rounded-lg" onclick="addReflection()">Add Reflection</button>
                            <button type="button" class="edit-btn bg-yellow-500 text-white py-2 px-4 rounded-lg" style="display:none;" onclick="saveReflection()">Save Reflection</button>
                            <button type="button" class="delete-current-btn bg-red-500 text-white py-2 px-4 rounded-lg" style="display:none;" onclick="deleteCurrentReflection()">Delete Reflection</button>
                            <button type="submit" class="submit-btn bg-blue-500 text-white py-2 px-4 rounded-lg">Submit</button>
                        </div>
                    </form>
                    <div class="reflections mt-6">
                        <!-- Reflection items will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .container {
            background: #fff;
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
        .buttons .add-btn {
            background-color: #38a169; /* Green */
            color: white;
        }
        .buttons .edit-btn {
            background-color: #f6ad55; /* Orange */
            color: white;
        }
        .buttons .delete-current-btn {
            background-color: #e53e3e; /* Red */
            color: white;
        }
        .buttons .submit-btn {
            background-color: #3182ce; /* Blue */
            color: white;
        }
        .reflections .reflection-item {
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

    <script>
        let reflections = [
            { id: 1, text: "I learned a lot about data structures today." },
            { id: 2, text: "I need to review algorithms for better understanding." }
        ];
        let editingReflectionId = null;

        // Render reflections to the page
        function renderReflections() {
            const reflectionContainer = document.querySelector('.reflections');
            reflectionContainer.innerHTML = '';
            reflections.forEach(reflection => {
                const reflectionItem = document.createElement('div');
                reflectionItem.classList.add('reflection-item');
                reflectionItem.innerHTML = `
                    <p>${reflection.text}</p>
                    <div class="action-btns">
                        <button onclick="populateEdit(${reflection.id})" class="edit-btn py-1 px-3 rounded-lg">Edit</button>
                        <button onclick="deleteReflection(${reflection.id})" class="delete-btn py-1 px-3 rounded-lg">Delete</button>
                    </div>
                `;
                reflectionContainer.appendChild(reflectionItem);
            });
        }

        // Add reflection to the list
        function addReflection() {
            const reflectionText = document.getElementById('reflection').value;
            if (!reflectionText) return alert("Reflection cannot be empty.");
            const newReflection = { id: Date.now(), text: reflectionText };
            reflections.push(newReflection);
            document.getElementById('reflection').value = '';
            renderReflections();
        }

        // Delete reflection from the list
        function deleteReflection(id) {
            reflections = reflections.filter(reflection => reflection.id !== id);
            renderReflections();
        }

        // Delete the current reflection being edited
        function deleteCurrentReflection() {
            if (editingReflectionId !== null) {
                deleteReflection(editingReflectionId);
                resetForm();
            }
        }

        // Populate the form with the reflection to edit
        function populateEdit(id) {
            const reflection = reflections.find(reflection => reflection.id === id);
            document.getElementById('reflection').value = reflection.text;
            document.querySelector('.add-btn').style.display = 'none';
            document.querySelector('.edit-btn').style.display = 'inline-block';
            document.querySelector('.delete-current-btn').style.display = 'inline-block';
            editingReflectionId = id;
        }

        // Save the edited reflection
        function saveReflection() {
            const reflectionText = document.getElementById('reflection').value;
            if (!reflectionText) return alert("Reflection cannot be empty.");
            const reflectionIndex = reflections.findIndex(reflection => reflection.id === editingReflectionId);
            reflections[reflectionIndex].text = reflectionText;
            document.getElementById('reflection').value = '';
            resetForm();
            renderReflections();
        }

        // Reset form and button visibility
        function resetForm() {
            document.getElementById('reflection').value = '';
            document.querySelector('.add-btn').style.display = 'inline-block';
            document.querySelector('.edit-btn').style.display = 'none';
            document.querySelector('.delete-current-btn').style.display = 'none';
            editingReflectionId = null;
        }

        // Handle form submission
        document.getElementById('reflection-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (editingReflectionId) {
                saveReflection();
            } else {
                addReflection();
            }
            resetForm();
        });

        // Initialize render
        renderReflections();e4f
    </script>
</x-app-layout>
