<aside class="w-64 pl-3 py-3 hidden md:block" aria-label="Sidebar">
   <div class="overflow-y-auto py-4 px-3 bg-white shadow rounded-lg sidebar">
      <ul class="space-y-2">
         <li>
            <a href="{{ route('dashboard') }}"
               class="sidebar-link{{ request()->is('dashboard') ? ' sidebar-active' : '' }}">
               <x-sidebar-logo>
                  <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                  <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
               </x-sidebar-logo>
               <span class="ml-3">Dashboard</span>
            </a>
         </li>
         <li>
            <button type="button"
               class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dropdown-user{{ request()->is('users*') || request()->is('roles*') || request()->is('permissions*') ? ' sidebar-active' : '' }}"
               aria-controls="dropdown-example" data-collapse-toggle="dropdown-example" id="dropdown-user">
               <x-sidebar-logo>
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                  </path>
               </x-sidebar-logo>
               <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>User
                  Management</span>
               <x-sidebar-logo class="hover:bg-gray-700">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </x-sidebar-logo>
            </button>
            <ul id="dropdown-example"
               class="{{ request()->is('users*') || request()->is('roles*') || request()->is('permissions*') ? '' : 'hidden ' }}py-2 space-y-2">
               <li>
                  <a href="{{ route('users.index') }}"
                     class="{{ request()->is('users*') ? 'font-bold ' : 'font-normal ' }}flex items-center p-2 pl-11 w-full text-base text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Users</a>
               </li>
               <li>
                  <a href="{{ route('roles.index') }}"
                     class="{{ request()->is('roles*') ? 'font-bold ' : 'font-normal ' }}flex items-center p-2 pl-11 w-full text-base text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Roles</a>
               </li>
               <li>
                  <a href="{{ route('permissions.index') }}"
                     class="{{ request()->is('permissions*') ? 'font-bold ' : 'font-normal ' }}flex items-center p-2 pl-11 w-full text-base text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Permissions</a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</aside>

@push('js')
<script>
   const dropdownButton = document.querySelectorAll(".dropdown-user");

   dropdownButton.forEach(button => {
      button.addEventListener('click', function() {
         const thisEl = document.querySelector(`#${this.id}`);
         const dropdownList = thisEl.nextElementSibling.classList.toggle("hidden");
      });
   });
</script>
@endpush