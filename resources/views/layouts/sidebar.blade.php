<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
 </button>

 <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full flex flex-col justify-between px-3 py-4 overflow-y-auto bg-gray-800">
       <a href="https://admin.joykonark.com/" class="flex items-center gap-2 ps-2.5 mb-5">
          <div class="flex bg-white rounded-xl w-12 h-12 border-2 border-pink-500">
            <img src="https://joykonark.com/wp-content/uploads/2024/05/logo.png" class=" w-full" alt="Joy konark Logo" />
          </div>
          <div class="flex flex-col text-left">
              <span class="text-xl font-semibold whitespace-nowrap text-pink-500">Joy konark</span>
              <span class="text-lg font-semibold whitespace-nowrap dark:text-white">CBCT Centre</span>
          </div>
       </a>
       <ul class="space-y-2 font-medium">

    @if(Auth::user()->role === 'representative')
        {{-- Only show Representatives tab --}}
        <li>
            <x-side-nav-link href="{{ route('representative.location') }}" :active="request()->routeIs('representative.location')">
                <i class="fi fi-sr-user-injured text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Dashboard') }}</span>
            </x-side-nav-link>
        </li>
    @else
        {{-- Show everything else for admin --}}
        <li>
            <x-side-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <i class="fi fi-sr-home text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Dashboard') }}</span>
            </x-side-nav-link>
        </li>

        <li>
            <x-side-nav-link href="{{ route('representatives.show') }}" :active="request()->routeIs('representatives.show')">
                <i class="fi fi-sr-user-injured text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Representatives') }}</span>
            </x-side-nav-link>
        </li>

        <li>
            <x-side-nav-link href="{{ route('patients.show') }}" :active="request()->routeIs('patients.show') || request()->routeIs('patients.edit')">
                <i class="fi fi-sr-user-injured text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Patients') }}</span>
            </x-side-nav-link>
        </li>

        <li>
            <x-side-nav-link href="{{ route('services.show') }}" :active="request()->routeIs('services.show')">
                <i class="fi fi-sr-boxes text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Services') }}</span>
            </x-side-nav-link>
        </li>

        <li>
            <x-side-nav-dropdown-link name="example" :active="request()->routeIs('doctors.*')">
                <i class="fi fi-sr-user-md text-xl w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white"></i>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap group-hover:text-white">Doctors</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </x-side-nav-dropdown-link>

            <ul id="dropdown-example" class="hidden pl-5 py-2 space-y-2">
                <li class="flex items-center gap-2">
                    <div class="bg-white h-1 w-1 rounded-full"></div>
                    <x-side-nav-dropdown-option-link href="{{ route('doctors.show') }}" :active="request()->routeIs('doctors.show')">
                        Approved
                    </x-side-nav-dropdown-option-link>
                </li>
                <li class="flex items-center gap-2">
                    <div class="bg-white h-1 w-1 rounded-full"></div>
                    <x-side-nav-dropdown-option-link href="{{ route('doctors.custom.show') }}" :active="request()->routeIs('doctors.custom.show')">
                        Unapproved
                    </x-side-nav-dropdown-option-link>
                </li>
            </ul>
        </li>

        <li>
            <x-side-nav-link href="{{ route('coupons.show') }}" :active="request()->routeIs('coupons.show')">
                <i class="fi fi-sr-ticket text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Coupons') }}</span>
            </x-side-nav-link>
        </li>

        <li>
            <x-side-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                <i class="fi fi-sr-user-pen text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Profile') }}</span>
            </x-side-nav-link>
        </li>

        <li>
            <x-side-nav-link href="{{ route('business.settings.show') }}" :active="request()->routeIs('business.settings.show')">
                <i class="fi fi-sr-settings text-xl w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"></i>
                <span class="ms-3">{{ __('Settings') }}</span>
            </x-side-nav-link>
        </li>
    @endif

</ul>

       <div class="flex h-10"></div>
    </div>
 </aside>
