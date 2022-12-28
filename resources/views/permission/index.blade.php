<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Permissions' => '#'])" />

        {{-- Search --}}
        <form action="{{ route('roles.index') }}">
            <x-search-input :value="$search" :action="route('roles.create')" />
        </form>

    </div>
</x-app-layout>