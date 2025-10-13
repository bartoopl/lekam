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

    .users-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    /* Table button styles */
    .table-button {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
        margin: 0 0.25rem;
    }

    .table-button.view {
        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        color: white !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .table-button.view:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        color: white !important;
    }

    .table-button.delete {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .table-button.delete:hover {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white !important;
    }

    /* Table styles */
    .admin-table {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .admin-table thead {
        background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
    }

    .admin-table th {
        color: #374151;
        font-weight: 600;
        text-shadow: none;
    }

    .admin-table td {
        color: #1F2937;
    }

    .admin-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1 class="admin-title">Zarządzanie Użytkownikami</h1>
        <a href="{{ route('admin.users.export') }}" class="admin-quick-action">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Eksportuj do CSV
        </a>
    </div>

    <div class="content-container">
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 admin-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Użytkownik
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Typ
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Liczba certyfikatów
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Zarejestrowany
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Akcje
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-gray-700">
                                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($user->user_type === 'farmaceuta') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                                    {{ $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik farmacji' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_admin)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Administrator
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Użytkownik
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $user->certificates->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="table-button view">
                                                    Edytuj
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Czy na pewno chcesz usunąć użytkownika {{ addslashes($user->name) }}? Ta operacja jest nieodwracalna.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="table-button delete" @if($user->id == auth()->user()->id) disabled title="Nie możesz usunąć swojego konta" @endif>
                                                        Usuń
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak użytkowników</h3>
                            <p class="mt-1 text-sm text-gray-500">Nie ma jeszcze żadnych użytkowników w systemie.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
