<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <h1 style="color: green">{{ session('success') }}</h1>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('view users')
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Actions</th>
                          </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td class="w-1/4 text-center">{{ $user->name }}</td>  
                            <td class="w-1/4 text-center">{{ $user->email }}</td>  
                            <td class="w-1/4 text-center">{{ $user->roles->pluck('name')->implode(', ') }}</td>  
                            <td class="w-1/4 text-center">
                                @if ($user->hasRole('b2b_customer') || $user->hasRole('b2c_customer'))
                                    <form style="display: inline" method="POST" action="{{ route('users.cancel_access', ['user' => $user->id]) }}">
                                        @csrf
                                        <button type="submit" class="justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel access</button>
                                    </form>
                                @endif
                        </td>  
                              

                            
                            

                        </tr>
                        @endforeach
                    </table>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
