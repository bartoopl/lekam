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

    .certificates-container {
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
        <h1 class="admin-title">Zarządzanie Certyfikatami</h1>
    </div>

    <div class="content-container">
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($certificates->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Certyfikat
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Użytkownik
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kurs
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Wydany
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Akcje
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($certificates as $certificate)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $certificate->certificate_number }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $certificate->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $certificate->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $certificate->course->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($certificate->is_valid) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                                    {{ $certificate->is_valid ? 'Ważny' : 'Wygasł' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $certificate->issued_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('certificates.show', $certificate) }}" class="text-blue-600 hover:text-blue-900">
                                                        Podgląd
                                                    </a>
                                                    <a href="{{ route('certificates.download', $certificate) }}" class="text-green-600 hover:text-green-900">
                                                        Pobierz
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $certificates->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak certyfikatów</h3>
                            <p class="mt-1 text-sm text-gray-500">Nie ma jeszcze żadnych certyfikatów w systemie.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
