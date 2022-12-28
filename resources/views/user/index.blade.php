<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Users' => '#'])" />

        {{-- Search --}}
        <form action="{{ route('users.index') }}">
            <x-search-input :value="$search" :action="route('users.create')" />
        </form>

        {{-- Table component --}}
        <x-table.table :headers="$headers">
            @foreach ($users as $key => $user)
            <tr class="even:bg-white">
                <x-table.td class="pl-5">
                    <x-button-action-delete href="{{ route('users.destroy', $user) }}" title="delete">{{
                        __('x')
                        }}
                    </x-button-action-delete>
                </x-table.td>

                <x-table.td class="pl-8">
                    {{ $key+1 }}
                </x-table.td>

                <x-table.td class="pl-8">
                    <a href="{{ route('users.edit', $user) }}" class="link" title="edit">
                        {{ $user->name }}
                    </a>
                </x-table.td>

                <x-table.td>
                    {{ $user->email }}
                </x-table.td>
            </tr>
            @endforeach
        </x-table.table>

        {{-- Pagination link --}}
        {{ $users->links() }}
    </div>

</x-app-layout>