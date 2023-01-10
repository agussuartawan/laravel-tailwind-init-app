<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Users' => route('users.index'), 'Create' => '#'])" />

        <form method="post" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="px-5 py-3 mb-4 text-gray-700 border border-gray-200 rounded-lg bg-white shadow space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Edit Users') }}
                    </h2>
                </header>

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$user->name"
                        required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="$user->email"
                        required autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="grid grid-cols-2 gap-4" x-data={show:true}>
                    <div>
                        <x-input-label for="role_id" :value="__('Role')" />
                        <x-select-input 
                            id="role_id" 
                            name="role_id"
                            x-on:change="show = true"
                            >
                            <option>~Choose~</option>
                            @foreach ($roles as $role)
                                <option {{ $user->roles->contains($role->id) ? "selected" : "" }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-select-input>
                    </div>

                    <div class="border-l-2 border-blue-500 min-h-fit" x-show=show>
                        <x-input-label :value="__('Permissions')" class="ml-2"/>
                        <div id="permissions">
                            @if($user->roles->first())
                                @foreach ($user->roles->first()->permissions as $permission)
                                    <x-default-badge class="ml-1">{{ $permission->name }}</x-default-badge>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>

    @push('js')
        <script>
            const selectRole = document.querySelector('#role_id');

            selectRole.addEventListener('change', () => {
                const roleId = selectRole.value;
                fetchPermissions(roleId);
            });

            const fetchPermissions = (roleId) => {
                fetch(`{{ url('users/get-permission-list') }}?role_id=${roleId}`)
                .then(response => response.json())
                .then(data => {
                    const permissionsEl = document.querySelector('#permissions');
                    permissionsEl.innerHTML = '';
                    data.forEach(item => {
                        item.permissions.forEach(permission => {
                            const badge = document.createElement('span');
                            badge.classList.add('bg-blue-100', 'text-blue-800', 'text-xs', 'font-medium', 'mx-1', 'px-2.5', 'py-0.5', 'rounded', 'inline-block');
                            badge.innerText = permission.name;
                            
                            permissionsEl.appendChild(badge);
                        })
                    });
                })
                .catch(error => {
                    
                });
            }
        </script>
    @endpush
</x-app-layout>
