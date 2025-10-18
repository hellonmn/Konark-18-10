<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
                <div class="grid grid-cols-3 gap-3 w-full">

                    <div class="flex items-center min-h-20 px-5 group relative border-2 border-gray-200 hover:shadow-xl hover:bg-primary hover:text-white hover:border-primary shadow-green-500 rounded-xl transition-all">
                        <span>Form 1</span>
                        <div class="hidden group-hover:flex absolute right-2 transition-all cursor-pointer">
                            <div class="flex gap-2">
                                <a href="{{ route('forms.edit') }}"><i data-tooltip-target="tooltip-edit" class="fi fi-rr-edit p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Edit
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <a href='/submissions'><i data-tooltip-target="tooltip-view" class="fi fi-rr-eye p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-view" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Submissions
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <i data-tooltip-target="tooltip-delete" class="fi fi-rr-trash p-2 rounded-full bg-red-500 text-white"></i>
                                <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Delete
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center min-h-20 px-5 group relative border-2 border-gray-200 hover:shadow-xl hover:bg-primary hover:text-white hover:border-primary shadow-green-500 rounded-xl transition-all">
                        <span>Form 2</span>
                        <div class="hidden group-hover:flex absolute right-2 transition-all cursor-pointer">
                            <div class="flex gap-2">
                                <a href="{{ route('forms.edit') }}"><i data-tooltip-target="tooltip-edit" class="fi fi-rr-edit p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Edit
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <a href='/submissions'><i data-tooltip-target="tooltip-view" class="fi fi-rr-eye p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-view" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Submissions
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <i data-tooltip-target="tooltip-delete" class="fi fi-rr-trash p-2 rounded-full bg-red-500 text-white"></i>
                                <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Delete
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center min-h-20 px-5 group relative border-2 border-gray-200 hover:shadow-xl hover:bg-primary hover:text-white hover:border-primary shadow-green-500 rounded-xl transition-all">
                        <span>Form 3</span>
                        <div class="hidden group-hover:flex absolute right-2 transition-all cursor-pointer">
                            <div class="flex gap-2">
                                <a href="{{ route('forms.edit') }}"><i data-tooltip-target="tooltip-edit" class="fi fi-rr-edit p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Edit
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <a href='/submissions'><i data-tooltip-target="tooltip-view" class="fi fi-rr-eye p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-view" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Submissions
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <i data-tooltip-target="tooltip-delete" class="fi fi-rr-trash p-2 rounded-full bg-red-500 text-white"></i>
                                <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Delete
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center min-h-20 px-5 group relative border-2 border-gray-200 hover:shadow-xl hover:bg-primary hover:text-white hover:border-primary shadow-green-500 rounded-xl transition-all">
                        <span>Form 4</span>
                        <div class="hidden group-hover:flex absolute right-2 transition-all cursor-pointer">
                            <div class="flex gap-2">
                                <a href="{{ route('forms.edit') }}"><i data-tooltip-target="tooltip-edit" class="fi fi-rr-edit p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Edit
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <a href='/submissions'><i data-tooltip-target="tooltip-view" class="fi fi-rr-eye p-2 rounded-full bg-green-500 text-white"></i></a>
                                <div id="tooltip-view" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Submissions
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <i data-tooltip-target="tooltip-delete" class="fi fi-rr-trash p-2 rounded-full bg-red-500 text-white"></i>
                                <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Delete
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
