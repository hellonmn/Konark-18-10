<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .form-element:hover .delete-btn {
            display: block;
        }
        .delete-btn {
            display: none;
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            text-align: center;
            cursor: pointer;
            line-height: 24px;
            font-size: 12px;
        }
        .dragging {
            opacity: 0.5;
        }
        .drag-over {
            border-top: 4px solid #3182ce;
        }
        .grab-handle {
            cursor: grab;
            background-color: #edf2f7;
            padding: 4px;
            margin-bottom: 8px;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            color: #2d3748;
        }
    </style>

    <div class="w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4 w-full flex flex-col gap-3">
            <div class="flex justify-between p-5 w-full h-full rounded-xl bg-white">
                <div class="flex">
                    <!-- Breadcrumb -->
                    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Home
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                            <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Forms</span>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                            <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Form 1</span>
                            </div>
                        </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex">
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                        <i class="fi fi-br-plus"></i>
                        <span>New form</span>
                    </button>
                </div>
            </div>
            <div class="flex p-5 bg-white rounded-xl w-full">
                <div class="container mx-auto">
                    <h1 class="text-3xl font-bold mb-6">Drag and Drop Form Builder</h1>
                    <div class="flex">
                        <!-- Toolbox -->
                        <div class="w-1/4 p-4 bg-white rounded-lg shadow-lg">
                            <h2 class="text-xl font-semibold mb-4">Toolbox</h2>
                            <div class="space-y-2">
                                <div draggable="true" class="draggable-item p-2 bg-blue-100 text-blue-700 rounded-lg cursor-move">
                                    Text Input
                                </div>
                                <div draggable="true" class="draggable-item p-2 bg-green-100 text-green-700 rounded-lg cursor-move">
                                    Radio Button
                                </div>
                                <div draggable="true" class="draggable-item p-2 bg-yellow-100 text-yellow-700 rounded-lg cursor-move">
                                    Checkbox
                                </div>
                                <div draggable="true" class="draggable-item p-2 bg-purple-100 text-purple-700 rounded-lg cursor-move">
                                    Text Area
                                </div>
                            </div>
                        </div>

                        <!-- Form Builder Area -->
                        <div class="w-3/4 p-4 ml-4 bg-white rounded-lg shadow-lg">
                            <h2 class="text-xl font-semibold mb-4">Form Builder</h2>
                            <div id="form-builder" class="relative min-h-[300px] border-2 border-dashed border-gray-300 p-4 rounded-lg">
                                <p class="text-gray-500">Drag and drop items here to build your form...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    const toolboxItems = document.querySelectorAll('.draggable-item');
                    const formBuilder = document.getElementById('form-builder');

                    // Handle drag start for toolbox items
                    toolboxItems.forEach(item => {
                        item.addEventListener('dragstart', function (e) {
                            e.dataTransfer.setData('text/plain', e.target.innerText);
                        });
                    });

                    // Handle drag over for form builder area
                    formBuilder.addEventListener('dragover', function (e) {
                        e.preventDefault();
                        const afterElement = getDragAfterElement(formBuilder, e.clientY);
                        const draggable = document.querySelector('.dragging');
                        if (afterElement == null) {
                            formBuilder.appendChild(draggable);
                        } else {
                            formBuilder.insertBefore(draggable, afterElement);
                        }
                    });

                    // Handle drop event
                    formBuilder.addEventListener('drop', function (e) {
                        e.preventDefault();
                        const itemType = e.dataTransfer.getData('text/plain');

                        let newElement = document.createElement('div');
                        newElement.classList.add('form-element', 'relative', 'p-4', 'border', 'rounded-lg', 'mb-4', 'bg-gray-100');
                        newElement.setAttribute('draggable', 'true');

                        let grabHandle = document.createElement('div');
                        grabHandle.classList.add('grab-handle');
                        grabHandle.innerHTML = '↕';

                        let deleteBtn = document.createElement('div');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '×';

                        deleteBtn.addEventListener('click', function () {
                            formBuilder.removeChild(newElement);
                        });

                        switch (itemType) {
                            case 'Text Input':
                                newElement.innerHTML += '<label class="block mb-2">Text Input:</label><input type="text" class="w-full p-2 border rounded-lg">';
                                break;
                            case 'Radio Button':
                                newElement.innerHTML += '<label class="block mb-2">Radio Button:</label><div><input type="radio" name="radio" class="mr-2">Option 1<br><input type="radio" name="radio" class="mr-2">Option 2</div>';
                                break;
                            case 'Checkbox':
                                newElement.innerHTML += '<label class="block mb-2">Checkbox:</label><div><input type="checkbox" class="mr-2">Check this box</div>';
                                break;
                            case 'Text Area':
                                newElement.innerHTML += '<label class="block mb-2">Text Area:</label><textarea class="w-full p-2 border rounded-lg" rows="4"></textarea>';
                                break;
                        }

                        newElement.prepend(grabHandle);
                        newElement.appendChild(deleteBtn);

                        // Enable dragging for the new element
                        newElement.addEventListener('dragstart', function () {
                            newElement.classList.add('dragging');
                        });

                        newElement.addEventListener('dragend', function () {
                            newElement.classList.remove('dragging');
                        });

                        const afterElement = getDragAfterElement(formBuilder, e.clientY);
                        if (afterElement == null) {
                            formBuilder.appendChild(newElement);
                        } else {
                            formBuilder.insertBefore(newElement, afterElement);
                        }
                    });

                    function getDragAfterElement(container, y) {
                        const draggableElements = [...container.querySelectorAll('.form-element:not(.dragging)')];

                        return draggableElements.reduce((closest, child) => {
                            const box = child.getBoundingClientRect();
                            const offset = y - box.top - box.height / 2;
                            if (offset < 0 && offset > closest.offset) {
                                return { offset: offset, element: child };
                            } else {
                                return closest;
                            }
                        }, { offset: Number.NEGATIVE_INFINITY }).element;
                    }
                </script>
            </div>
        </div>
    </div>





    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Create New Form
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Form Name</label>
                            <input type="text" name="form_name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Type form name" required="">
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Add new form
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
