@props(['enctype' => null])
<div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-md dark:bg-dark border dark:border-primary-darker">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                data-modal-hide="{{ $modalId }}">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-primary-light uppercase">{{ $modalHeader }}</h3>
                <form class="space-y-6" action="{{ URL($actionUrl) }}" method="post" enctype="{{ $enctype }}">
                  @csrf
                  {{ $inputBox }}
                    <button type="submit"
                        class="w-full text-white bg-primary hover:bg-primary-dark dark:text-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded shadow-md shadow-blue-500 text-sm px-5 py-2.5 text-center  dark:focus:ring-blue-800">Save</button>
                    <button data-modal-hide="{{ $modalId }}" type="button" class="w-full text-white hover:text-blue-500  bg-blue-500 hover:bg-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded shadow-md shadow-blue-300 text-sm px-5 py-2.5 text-center dark:focus:ring-blue-800">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
