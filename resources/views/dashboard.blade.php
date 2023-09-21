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



                    @can('view dashboard')

                        @can('access b2b')
                            <h1 class="text-xl font-semibold">B2B Purchase Details</h1>
                        @endcan

                        @can('access b2c')
                            <h1 class="text-xl font-semibold">B2C Purchase Details</h1>
                        @endcan

                        <table class="">
                            <tr>
                                <th>CC Last four</th>
                                {{-- <th>Payment Intent ID</th> --}}
                                <th>Actions</th>
                            </tr>                        

                        @foreach (Auth::user()->purchases as $purchase)
                        <tr>
                            <td class="w-1/3 text-center">{{ $purchase->pm_last_four }}</td>
                            {{-- <td class="w-1/3 text-center"> {{ $purchase->payment_intent_id }} </td> --}}
                            <td class="w-1/3 text-center">
                                @if (!$purchase->is_refunded)
                                    <form method="POST" action="{{ route('purchases.refund', ['purchase' => $purchase->id]) }}">
                                        @csrf
                                        <button type="submit" class="justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Refund
                                        </button>
                                    </form>
                                @endif
                                
                            </td>
                        </tr>
                            
                        @endforeach

                    </table>

                    @endcan


                    @cannot('view dashboard')
                        <form method="POST" action="{{ route('purchases.store') }}">
                            @csrf

                            <input type="radio" id="type_b2b" value="b2b" name="type" required><label
                                for="type_b2b">B2B</label>
                            <input type="radio" id="type_b2c" value="b2c" name="type" required><label
                                for="type_b2c">B2C</label>

                            <button class="justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Purchase
                            <button
                        </form>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
