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
                        @if($role->name != \App\Models\User::SUPER_ADMIN)
                        <x-button-action-delete onclick="submitForm('{{ route('roles.destroy', $role) }}')" 
                        title="delete"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-role-deletion')">{{
                            __('x')
                            }}
                        </x-button-action-delete>
                        @endif
                    </x-table.td>

                    <x-table.td class="pl-10">
                        {{ $key+1 }}
                    </x-table.td>

                    <x-table.td class="pl-8">
                        @if($role->name != \App\Models\User::SUPER_ADMIN)
                            <a href="{{ route('roles.edit', $role) }}" class="link" title="edit">
                                {{ $role->name }}
                            </a>
                        @else
                            {{ $role->name }}
                        @endif
                    </x-table.td>

                    <x-table.td>
                        @if($role->name == \App\Models\User::SUPER_ADMIN)
                            <x-success-badge>{{ __('All permissions') }}</x-success-badge>
                        @else
                            @forelse ($role->permissions as $permission)
                                <x-default-badge>
                                    <a href="{{ route('permissions.edit', $permission) }}" class="link">
                                        {{ $permission->name }}
                                    </a>
                                </x-default-badge>
                            @empty
                                <x-secondary-badge>{{ __('No permissions set') }}</x-secondary-badge>
                            @endforelse
                        @endif
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

    {{-- delete modal --}}
    <x-modal name="confirm-role-deletion" :show="false" focusable>
        <form method="POST" name="delete-form" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this role?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Role') }}
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