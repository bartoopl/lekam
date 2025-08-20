@extends('layouts.app')

@section('content')
<style>
    html, body {
        background-image: url('/images/backgrounds/bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .admin-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .admin-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #21235F;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .admin-quick-action {
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        color: white !important;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .admin-quick-action:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        transform: translateY(-2px);
        color: white !important;
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .stats-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1 class="admin-title">Statystyki Platformy</h1>
    </div>

    <div class="content-container">
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statystyki użytkowników</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-blue-600">Farmaceuci</div>
                            <div class="text-2xl font-bold text-blue-900">{{ $stats['users_by_type']['farmaceuta'] }}</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-green-600">Technicy farmacji</div>
                            <div class="text-2xl font-bold text-green-900">{{ $stats['users_by_type']['technik_farmacji'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statystyki kursów</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-green-600">Podstawowy</div>
                            <div class="text-2xl font-bold text-green-900">{{ $stats['courses_by_difficulty']['podstawowy'] }}</div>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-yellow-600">Średni</div>
                            <div class="text-2xl font-bold text-yellow-900">{{ $stats['courses_by_difficulty']['średni'] }}</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-red-600">Zaawansowany</div>
                            <div class="text-2xl font-bold text-red-900">{{ $stats['courses_by_difficulty']['zaawansowany'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ostatnia aktywność (ostatnie 7 dni)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-purple-600">Nowi użytkownicy</div>
                            <div class="text-2xl font-bold text-purple-900">{{ $stats['recent_activity']['new_users'] }}</div>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-yellow-600">Nowe certyfikaty</div>
                            <div class="text-2xl font-bold text-yellow-900">{{ $stats['recent_activity']['new_certificates'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Representative Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statystyki przedstawicieli</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-blue-600">Łącznie przedstawicieli</div>
                            <div class="text-2xl font-bold text-blue-900">{{ $stats['representatives']['total'] }}</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-green-600">Aktywni przedstawiciele</div>
                            <div class="text-2xl font-bold text-green-900">{{ $stats['representatives']['active'] }}</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-purple-600">Z rejestracjami</div>
                            <div class="text-2xl font-bold text-purple-900">{{ $stats['representatives']['with_registrations'] }}</div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-orange-600">Rejestracje w tym miesiącu</div>
                            <div class="text-2xl font-bold text-orange-900">{{ $stats['representatives']['registrations_this_month'] }}</div>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-indigo-600">Średnio rejestracji na przedstawiciela</div>
                            <div class="text-2xl font-bold text-indigo-900">
                                @if($stats['representatives']['active'] > 0)
                                    {{ round(($stats['users_by_type']['farmaceuta'] + $stats['users_by_type']['technik_farmacji']) / $stats['representatives']['active'], 1) }}
                                @else
                                    0
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($stats['representatives']['top_performers']->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Top 5 przedstawicieli</h4>
                            <div class="space-y-2">
                                @foreach($stats['representatives']['top_performers'] as $representative)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $representative->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $representative->email }}</div>
                                        </div>
                                        <div class="text-lg font-bold text-gray-900">
                                            {{ $representative->users_count }} rejestracji
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Platform Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Przegląd platformy</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-900">Łączna liczba użytkowników</div>
                                <div class="text-sm text-gray-500">Wszyscy zarejestrowani użytkownicy</div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['users_by_type']['farmaceuta'] + $stats['users_by_type']['technik_farmacji'] }}
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-900">Łączna liczba kursów</div>
                                <div class="text-sm text-gray-500">Wszystkie dostępne kursy</div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['courses_by_difficulty']['podstawowy'] + $stats['courses_by_difficulty']['średni'] + $stats['courses_by_difficulty']['zaawansowany'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
