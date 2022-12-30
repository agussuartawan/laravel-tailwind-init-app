<div class="flex justify-center items-start inset-0 z-100 absolute mt-10" x-data="{ show: true }" x-show="show"
    x-on:click="show=false" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
    <div id="toast-success"
        class="flex items-center p-4 mb-4 w-full max-w-xs bg-gradient-to-b from-green-300 to-green-100 rounded-lg shadow"
        role="alert">
        <div
            class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ml-3 text-sm font-normal">{{ $slot }}</div>
    </div>
</div>