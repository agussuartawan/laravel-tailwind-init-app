<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Roles' => '#'])" />

        {{-- Search --}}
        <form action="{{ route('roles.index') }}" id="filter-form">
            <input type="hidden" name="page" value="{{ request()->input('page') }}">
            <x-search-input :value="request()->input('search')" :action="route('roles.create')" />

            {{-- Table component --}}
            <x-table.table :headers="$headers">
                @forelse ($data as $key => $role)
                <tr class="even:bg-white">
                    <x-table.td class="pl-5">
                        <x-button-action-delete href="{{ route('roles.destroy', $role) }}" title="delete">{{
                            __('x')
                            }}
                        </x-button-action-delete>
                    </x-table.td>

                    <x-table.td class="pl-10">
                        {{ $key+1 }}
                    </x-table.td>

                    <x-table.td class="pl-8">
                        <a href="{{ route('roles.edit', $role) }}" class="link" title="edit">
                            {{ $role->name }}
                        </a>
                    </x-table.td>

                    <x-table.td>
                        {{ $role->email }}
                    </x-table.td>
                </tr>
                @empty
                <tr>
                    <x-table.td colspan="4" class="text-center">
                        {{ __('No data available.') }}
                    </x-table.td>
                </tr>
                @endforelse
            </x-table.table>
        </form>


        {{-- Pagination link --}}
        {{ $data->withQueryString()->links() }}

    </div>
</x-app-layout>