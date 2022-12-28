<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($message = Session::get('success'))
        <x-success-toast>{{ $message }}</x-success-toast>
        @endif

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Permissions' => '#'])" />

        {{-- Search --}}
        <form action="{{ route('permissions.index') }}">
            <x-search-input :value="$search" :action="route('permissions.create')" />
        </form>

        {{-- Table component --}}
        <x-table.table :headers="$headers">
            @forelse ($data as $key => $permission)
            <tr class="even:bg-white">
                <x-table.td class="pl-5">
                    <x-button-action-delete href="{{ route('permissions.destroy', $permission) }}" title="delete">{{
                        __('x')
                        }}
                    </x-button-action-delete>
                </x-table.td>

                <x-table.td class="pl-8">
                    {{ $key+1 }}
                </x-table.td>

                <x-table.td class="pl-8">
                    <a href="{{ route('permissions.edit', $permission) }}" class="link" title="edit">
                        {{ $permission->name }}
                    </a>
                </x-table.td>
            </tr>
            @empty
            <tr>
                <x-table.td colspan="3" class="text-center">
                    {{ __('No data available.') }}
                </x-table.td>
            </tr>
            @endforelse
        </x-table.table>

        {{-- Pagination link --}}
        {{ $data->links() }}

    </div>
</x-app-layout>