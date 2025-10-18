<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container p-5 mx-auto">
        <div class="flex justify-between p-4 bg-white rounded-xl mb-4">
            <h1 class="text-2xl text-gray-700 font-bold">Dashboard</h1>
            <div class="flex gap-2">
                        <button id="filterDropdown" data-dropdown-toggle="filter-dropdown" class="relative flex items-center justify-center text-black bg-gray-100 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            <i class="fi fi-br-filter"></i>
                            @if($isDateFilterActive)
                                <div class="flex items-center justify-center absolute top-0 right-0 bg-red-500 rounded-full w-4 h-4 text-white text-sm" style="text-size:10px">1</div>
                            @endif
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div id="filter-dropdown" class="absolute z-10 p-2 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl border w-96">
                            <form class="w-full">
                                <div class="flex items-centre justify-centre w-full">
                                    <ul class="p-2 bg-pink-100 rounded-xl w-full" aria-labelledby="filterDropdown">
                                        <label for="fromDate" class="block text-sm mb-2 font-medium text-gray-900">From Date</label>
                                        <input type="date" id="fromDate" name="fromDate" value="{{$fromDate}}"
                                            class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" required="">
                                    </ul>
                                    <ul class="flex items-center justify-center">
                                        <div class="bg-pink-100 w-5 h-1"></div>
                                    </ul>
                                    <ul class="p-2 bg-pink-100 rounded-xl w-full" aria-labelledby="filterDropdown">
                                        <label for="toDate" class="block text-sm mb-2 font-medium text-gray-900">To Date</label>
                                        <input type="date" id="toDate" name="toDate" value="{{$toDate}}"
                                            class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" required="">
                                    </ul>
                                </div>
                                <button class="w-full mt-2 text-white bg-primary hover:bg-pink-500 focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
                                    Apply
                                </button>
                                @if($isDateFilterActive)
                                    <button href="{{ route('doctors.show') }}" class="w-full mt-2 text-gray-700 bg-gray-100 hover:bg-pink-100 focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
                                        Clear
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Revenue Card -->
            <div class="relative flex gap-2 items-center bg-pink-400 rounded-xl p-6">
                @if($isDateFilterActive)
                    <div class="flex items-center justify-center absolute p-2 top-2 right-2 bg-pink-200 rounded-xl w-min text-nowrap text-primary text-sm" style="text-size:10px">Filter Applied</div>
                @endif
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-white text-2xl text-primary">
                    <i class="fi fi-sr-sack-dollar"></i>
                </div>
                <div class="">
                    <h2 class="text-lg font-semibold text-gray-700">Total Revenue</h2>
                    <p class="text-2xl font-bold text-white w-min">₹{{ $totalRevenue }}</p>
                </div>
            </div>

            <!-- New Patients This Month -->
            <div class="flex gap-2 items-center bg-blue-400 rounded-xl p-6">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-white text-2xl text-blue-500">
                    <button id="prevMonth" class="text-sm text-gray-700 hover:bg-gray-200 p-2 rounded-lg">
                        <i class="fi fi-sr-angle-left"></i>
                    </button>
                    <button id="nextMonth" class="text-sm text-gray-700 hover:bg-gray-200 p-2 rounded-lg">
                        <i class="fi fi-sr-angle-right"></i>
                    </button>
                </div>
                <div class="">
                    <h2 class="flex text-sm font-semibold text-gray-700"><span>Patients in</span> <h2 class="text-lg font-semibold text-gray-700" id="activeMonth">{{ \Carbon\Carbon::createFromFormat('m', $currentMonth)->format('F Y') }}</h2></h2>
                    <p id="patientsCount" class="text-2xl font-bold text-white w-min">{{ $newPatientsThisMonth }}</p>
                </div>
            </div>

            <!-- Revenue This Month -->
            <div class="flex gap-2 items-center bg-green-400 rounded-xl p-6">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-white text-2xl text-green-500">
                    <i class="fi fi-sr-calendar-payment-loan"></i>
                </div>
                <div class="">
                    <h2 class="text-lg font-semibold text-gray-700">Revenue This Month</h2>
                    <p class="text-2xl font-bold text-white w-min">₹{{ $revenueThisMonth }}</p>
                </div>
            </div>

            <!-- Services Breakdown -->
            <div class="bg-white rounded-xl">
                <div class="flex items-center gap-2 p-5 border-b">
                        <div class="w-4 h-4 rounded-full bg-primary"></div>
                        <h2 class="text-xl font-semibold">Services Breakdown</h2>
                </div>
                <canvas id="servicesChart" class="p-6"></canvas>
            </div>

            <!-- Gender Distribution -->
            <div class="bg-white rounded-xl">
                <div class="flex items-center gap-2 p-5 border-b">
                        <div class="w-4 h-4 rounded-full bg-primary"></div>
                        <h2 class="text-xl font-semibold">Gender Distribution</h2>
                </div>
                <canvas id="genderChart" class="p-6"></canvas>
            </div>
            
            <!-- Recent Appointments Section -->
                <div class="bg-white rounded-xl">
                    <div class="flex items-center gap-2 p-5 border-b">
                        <div class="w-4 h-4 rounded-full bg-primary"></div>
                        <h2 class="text-xl font-semibold">Recent Appointments</h2>
                    </div>
                    <ul class="p-1 mb-6">
                        @foreach ($recentAppointments as $appointment)
                            <li class="flex justify-between">
                                <div class="hover:bg-gray-100 cursor-pointer w-full p-3 rounded-xl border-b group">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-100 text-xl text-green-500">
                                            <i class="fi fi-sr-user"></i>
                                        </div>
                                        <div class="">
                                            <h3 class="font-bold group-hover:text-primary">{{ $appointment->name }}</h3>
                                            <p class="text-gray-500">{{ $appointment->appointment_date }} at {{ $appointment->appointment_time }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-500">{{ $appointment->service_names }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>

        </div>
        

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <!-- Monthly Revenue Chart -->
            <div class="bg-white rounded-xl mt-4">
                <div class="flex items-center gap-2 p-5 border-b">
                    <div class="w-4 h-4 rounded-full bg-primary"></div>
                    <h2 class="text-xl font-semibold">Monthly Revenue <h2 class="flex items-center justify-center text-center text-sm text-red-500 p-2 rounded-full h-6 w-6 font-bold bg-red-200">β</h2></h2>
                </div>
                <canvas id="monthlyRevenueChart" class="p-6"></canvas>
            </div>
            <!-- Age Distribution -->
            <div class="bg-white rounded-xl mt-4">
                <div class="flex items-center gap-2 p-5 border-b">
                        <div class="w-4 h-4 rounded-full bg-primary"></div>
                        <h2 class="text-xl font-semibold">Age Distribution</h2>
                </div>
                    <div style="height:auto; width:600px">
                        <canvas id="ageChart" class="p-6 "></canvas>   
                    </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Services Chart
        const servicesData = @json($patientsWithServices->pluck('service_names')->flatten()->countBy()->all());
        const ctxServices = document.getElementById('servicesChart').getContext('2d');
        new Chart(ctxServices, {
            type: 'pie',
            data: {
                labels: Object.keys(servicesData),
                datasets: [{
                    data: Object.values(servicesData),
                    backgroundColor: ['#f472b6', '#fbbf24', '#60a5fa', '#34d399', '#fbbf24', '#c1121f', '#ccc5b9', '#709775', '#7b2cbf'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Gender Distribution Chart
        const genderData = @json($genderDistribution->toArray());
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: Object.keys(genderData),
                datasets: [{
                    data: Object.values(genderData),
                    backgroundColor: ['#fbbf24', '#60a5fa', '#34d399'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Age Distribution Chart
        const ageData = @json(array_values($ageGroups));
        const ctxAge = document.getElementById('ageChart').getContext('2d');
        new Chart(ctxAge, {
            type: 'bar',
            data: {
                labels: Object.keys(@json($ageGroups)),
                datasets: [{
                    label: 'Number of Patients',
                    data: ageData,
                    backgroundColor: '#f472b6',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthlyLabels = @json($monthlyLabels);
        const monthlyValues = @json($monthlyValues);

        const ctxMonthlyRevenue = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(ctxMonthlyRevenue, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: monthlyValues,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `₹${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Revenue (₹)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        let currentMonth = {{ $currentMonth }};
        let currentYear = {{ $currentYear }};
        const prevMonth = {{ $previousMonth }};
        const prevYear = {{ $previousYear }};
        const nextMonth = {{ $nextMonth }};
        const nextYear = {{ $nextYear }};

        function updatePatientCount(month, year) {
            $.ajax({
                url: '{{ route('dashboard.getPatientCount') }}',
                method: 'GET',
                data: {
                    month: month,
                    year: year
                },
                success: function(response) {
                    $('#patientsCount').text(response.patientsCount);
                    $('#activeMonth').text(new Date(year, month - 1).toLocaleString('default', { month: 'long' }) + ' ' + year);
                }
            });
        }

        $('#prevMonth').on('click', function () {
            if (currentMonth === 1) {
                currentMonth = 12;
                currentYear--;
            } else {
                currentMonth--;
            }
            updatePatientCount(currentMonth, currentYear);
        });

        $('#nextMonth').on('click', function () {
            if (currentMonth === 12) {
                currentMonth = 1;
                currentYear++;
            } else {
                currentMonth++;
            }
            updatePatientCount(currentMonth, currentYear);
        });
    });
    </script>



    
</x-app-layout>
