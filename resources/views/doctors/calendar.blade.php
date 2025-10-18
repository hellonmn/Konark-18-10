<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .calendar-day {
            @apply p-2 text-center rounded-lg cursor-pointer;
        }

        .calendar-day.highlight {
            @apply bg-pink-100;
        }
    </style>

    <div class="w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4 w-full flex flex-col gap-3">
            <div class="flex justify-between p-5 w-full h-full rounded-xl bg-white">
                <div class="flex">
                    <!-- Breadcrumb -->
                    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
                        aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="#"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Home
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span
                                        class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Doctors</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="flex">
                    <div class="flex gap-2 text-nowrap  w-min bg-plight p-4 rounded-xl text-primary">
                        <strong>Inactive from:</strong>{{$inactiveDays}} days
                    </div>
                </div>
            </div>

            <div class="p-5 bg-white rounded-xl w-full">
                <style>
                    .calendar-day {
                        @apply p-2 text-center rounded-lg cursor-pointer;
                    }

                    .calendar-day.highlight {
                        @apply bg-pink-100;
                    }
                </style>

                <div class="w-full">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-4 w-full flex flex-col gap-3">


                        <div class="bg-white rounded-xl w-full">
                            <div class="w-full">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-4 w-full flex flex-col gap-3">
                                    <!-- Tab navigation -->
                                    <div class="flex border-b mb-4">
                                        <button id="calendarTab" class="px-4 rounded-t-lg py-2 mx-2 text-gray-700 hover:bg-pink-100 active w-full border-b border-primary" onclick="showTab('calendar')">Calendar</button>
                                        <button id="analyticsTab" class="px-4 rounded-t-lg py-2 mx-2 text-gray-700 hover:bg-pink-100 w-full" onclick="showTab('analytics')">Analytics</button>
                                    </div>

                                    <!-- Tab content -->
                                    <div id="calendarContent" class="tab-content">
                                        <div class="bg-white rounded-xl w-full">
                                            <div class="container mx-auto">
                                                <h1 class="text-2xl font-bold mb-4">Doctor's Calendar</h1>

                                                <div class="flex justify-between mb-4">
                                                    <button id="prevMonth" class="bg-primary text-white px-4 py-2 rounded">Previous Month</button>
                                                    <div id="currentMonth" class="text-lg font-semibold"></div>
                                                    <button id="nextMonth" class="bg-primary text-white px-4 py-2 rounded">Next Month</button>
                                                </div>

                                                <div id="calendar" class="grid grid-cols-7 gap-1 mb-4"></div>

                                                <!-- Event Display Area -->
                                                <div id="eventDetails" class="p-4 bg-pink-100 rounded-lg"></div>

                                                {{-- <button onclick="window.history.back()" class="bg-red-500 mt-5 text-white px-4 py-2 rounded">Back</button> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div id="analyticsContent" class="tab-content hidden">
                                        <div class="bg-white rounded-xl w-full p-5">
                                            <h2 class="text-2xl font-bold mb-4">Analytics</h2>
                                            <canvas id="patientsChart" class="mb-4"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appointments = @json($appointments);
            console.log('Appointments Data:', appointments); // Debugging: Check the data passed

            let currentMonth = new Date().getMonth();
            let currentYear = new Date().getFullYear();

            document.getElementById('prevMonth').addEventListener('click', () => {
                if (currentMonth === 0) {
                    currentMonth = 11;
                    currentYear--;
                } else {
                    currentMonth--;
                }
                renderCalendar(appointments, currentYear, currentMonth);
            });

            document.getElementById('nextMonth').addEventListener('click', () => {
                if (currentMonth === 11) {
                    currentMonth = 0;
                    currentYear++;
                } else {
                    currentMonth++;
                }
                renderCalendar(appointments, currentYear, currentMonth);
            });

            renderCalendar(appointments, currentYear, currentMonth);
            renderPatientsChart(appointments);
        });

        function renderCalendar(appointments, year, month) {
            const calendarEl = document.getElementById('calendar');
            const eventDetailsEl = document.getElementById('eventDetails');
            calendarEl.innerHTML = '';

            const now = new Date();
            const todayYear = now.getFullYear();
            const todayMonth = now.getMonth();
            const today = now.getDate();

            const firstDayOfMonth = new Date(year, month, 1);
            const lastDayOfMonth = new Date(year, month + 1, 0);
            const numberOfDays = lastDayOfMonth.getDate();
            const startingDay = firstDayOfMonth.getDay();

            document.getElementById('currentMonth').textContent = `${firstDayOfMonth.toLocaleString('default', { month: 'long' })} ${year}`;

            const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            weekdays.forEach(day => {
                const header = document.createElement('div');
                header.className = 'text-gray-600 font-semibold text-center';
                header.textContent = day;
                calendarEl.appendChild(header);
            });

            for (let i = 0; i < startingDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day';
                calendarEl.appendChild(emptyDay);
            }

            for (let day = 1; day <= numberOfDays; day++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day rounded-xl p-2 text-center cursor-pointer';
                dayEl.textContent = day;

                // Proper date format with leading zeros for month and day
                const dateStr = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                console.log('Checking Date:', dateStr); // Debugging: Check each date

                const dayAppointments = appointments.filter(app => app.appointment_date === dateStr);
                console.log('Appointments on', dateStr, ':', dayAppointments); // Debugging: Log appointments for each date

                if (dayAppointments.length > 0) {
                    dayEl.classList.add('bg-pink-100', 'highlight');
                    dayEl.addEventListener('click', () => showEvents(dayAppointments, dateStr));
                }

                // Highlight today's date with bg-pink-400
                if (year === todayYear && month === todayMonth && day === today) {
                    dayEl.classList.add('bg-pink-400', 'text-white');
                }

                calendarEl.appendChild(dayEl);
            }
        }

        function showEvents(appointments, date) {
            const eventDetailsEl = document.getElementById('eventDetails');
            eventDetailsEl.innerHTML = `<h2 class="text-xl font-semibold mb-2">Appointments on ${date}</h2>`;

            if (appointments.length > 0) {
                appointments.forEach(app => {
                    eventDetailsEl.innerHTML += `
                <div class="p-2 mb-2 bg-white rounded-lg shadow">
                    <p><strong>Patient Name:</strong> ${app.name}</p>
                    <p><strong>Time:</strong> ${app.appointment_time}</p>
                </div>
            `;
                });
            } else {
                eventDetailsEl.innerHTML = `<p>No appointments for this date.</p>`;
            }
        }

        function renderPatientsChart(appointments) {
            const ctx = document.getElementById('patientsChart').getContext('2d');

            const patientsData = Array(12).fill(0); // Initialize an array for 12 months with 0 patients

            appointments.forEach(app => {
                const month = new Date(app.appointment_date).getMonth(); // Get the month index (0-11)
                patientsData[month] += 1; // Increment the patient count for the corresponding month
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: 'Total Patients',
                        data: patientsData,
                        backgroundColor: 'rgba(219, 39, 119, 0.7)', // Pink-400 color
                        borderColor: 'rgba(219, 39, 119, 1)', // Pink-400 color
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // Ensure no decimal places
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(219, 39, 119, 1)', // Pink-400 color
                            }
                        }
                    }
                }
            });
        }

        function showTab(tabName) {
            const tabs = ['calendar', 'analytics'];
            tabs.forEach(tab => {
                const tabContent = document.getElementById(`${tab}Content`);
                const tabButton = document.getElementById(`${tab}Tab`);
                if (tab === tabName) {
                    tabContent.classList.remove('hidden');
                    tabButton.classList.add('active', 'border-b', 'border-primary');
                } else {
                    tabContent.classList.add('hidden');
                    tabButton.classList.remove('active', 'border-b', 'border-primary');
                }
            });
        }
    </script>
</x-app-layout>
