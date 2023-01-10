<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Permissions' => '#'])" />

        <form action="{{ route('permissions.index') }}" id="filter-form">
            <input type="hidden" name="page" value="{{ request()->input('page') }}">
            {{-- Search --}}
            <x-search-input :value="request()->input('search')" :action="route('permissions.create')" />

            {{-- Table component --}}
            <x-table.table :headers="$headers">
                @forelse ($data as $key => $permission)
                <tr class="even:bg-white">
                    <x-table.td class="pl-5">
                        <x-button-action-delete 
                        onclick="submitForm('{{ route('permissions.destroy', $permission) }}')" 
                        title="delete"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-permission-deletion')">
                        {{  __('x') }}
                        </x-button-action-delete>
                    </x-table.td>

                    <x-table.td class="pl-10">
                        {{ $key+1 }}
                    </x-table.td>

                    <x-table.td class="pl-8">
                        <a href="{{ route('permissions.edit', $permission) }}" class="link" title="edit">
                            {{ $permission->name }}
                        </a>
                    </x-table.td>

                    <x-table.td>
                        @forelse ($permission->roles as $role)
                            <x-default-badge>
                                <a href="{{ route('roles.edit', $role) }}" class="link">
                                    {{ $role->name }}
                                </a>
                            </x-default-badge>
                        @empty
                            <x-secondary-badge>{{ __('No role set') }}</x-secondary-badge>
                        @endforelse
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
        </form>

        {{-- Pagination link --}}
        {{ $data->withQueryString()->links() }}

    </div>

    {{-- delete modal --}}
    <x-modal name="confirm-permission-deletion" :show="false" focusable>
        <form method="POST" name="delete-form" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this permission?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Permission') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    @push('js')
        <script>
            const submitForm = (action) => {
                const form = document.forms.namedItem("delete-form");
                form.action = action;
            }
        </script>
    @endpush
</x-app-layout>