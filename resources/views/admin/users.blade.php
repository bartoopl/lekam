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
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem;
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
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow-x: hidden;
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
        width: 100%;
        table-layout: fixed;
    }

    .admin-table th,
    .admin-table td {
        padding: 0.75rem 0.5rem;
        text-align: left;
        border-bottom: 1px solid #f3f4f6;
    }

    .admin-table th:nth-child(1),
    .admin-table td:nth-child(1) {
        width: 25%;
    }

    .admin-table th:nth-child(2),
    .admin-table td:nth-child(2) {
        width: 12%;
    }

    .admin-table th:nth-child(3),
    .admin-table td:nth-child(3) {
        width: 12%;
    }

    .admin-table th:nth-child(4),
    .admin-table td:nth-child(4) {
        width: 10%;
        text-align: center;
    }

    .admin-table th:nth-child(5),
    .admin-table td:nth-child(5) {
        width: 15%;
    }

    .admin-table th:nth-child(6),
    .admin-table td:nth-child(6) {
        width: 26%;
        text-align: center;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .admin-table th:nth-child(1),
        .admin-table td:nth-child(1) {
            width: 22%;
        }

        .admin-table th:nth-child(6),
        .admin-table td:nth-child(6) {
            width: 29%;
        }
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem;
        }

        .users-container {
            padding: 1rem;
        }

        .admin-table th,
        .admin-table td {
            padding: 0.5rem 0.25rem;
            font-size: 0.875rem;
        }

        .table-button {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            margin: 0 0.125rem;
        }
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

    /* Pagination styles */
    .pagination-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 10px;
    }

    .pagination-stats {
        color: #4B5563;
        font-size: 0.9rem;
    }

    nav[role="navigation"] {
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .pagination a {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
    }

    .pagination a:hover {
        background: #3B82F6;
        color: white;
        transform: translateY(-1px);
    }

    .pagination .active span {
        background: #3B82F6;
        color: white;
    }

    .pagination .disabled span {
        background: rgba(156, 163, 175, 0.1);
        color: #9CA3AF;
        cursor: not-allowed;
    }

    /* Ensure pagination is visible */
    .pagination-container {
        display: flex !important;
        justify-content: center !important;
        margin-top: 2rem !important;
    }

    .pagination {
        display: flex !important;
        gap: 0.5rem !important;
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .pagination li {
        display: inline-block !important;
    }

    .pagination a,
    .pagination span {
        display: inline-block !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 0.5rem !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        font-weight: 500 !important;
        min-width: 44px !important;
        text-align: center !important;
    }

    /* Tailwind pagination overrides */
    nav[role="navigation"] {
        display: flex !important;
        justify-content: center !important;
        margin-top: 1rem !important;
    }

    nav[role="navigation"] .relative.z-0 {
        display: flex !important;
        gap: 0.25rem !important;
    }

    nav[role="navigation"] a,
    nav[role="navigation"] span[aria-current="page"],
    nav[role="navigation"] span[aria-disabled="true"] {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 0.375rem !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        min-width: 44px !important;
        border: 1px solid #d1d5db !important;
        background-color: #ffffff !important;
        color: #374151 !important;
        transition: all 0.15s ease-in-out !important;
    }

    nav[role="navigation"] a:hover {
        background-color: #f9fafb !important;
        color: #6b7280 !important;
        border-color: #9ca3af !important;
    }

    nav[role="navigation"] span[aria-current="page"] {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        border-color: #3b82f6 !important;
    }

    nav[role="navigation"] span[aria-disabled="true"] {
        background-color: #f9fafb !important;
        color: #d1d5db !important;
        cursor: not-allowed !important;
        opacity: 0.5 !important;
    }

    /* Mobile responsive */
    @media (max-width: 640px) {
        nav[role="navigation"] .flex.justify-between {
            display: flex !important;
            justify-content: space-between !important;
            width: 100% !important;
        }

        nav[role="navigation"] .hidden.sm\\:flex-1 {
            display: none !important;
        }
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
                            <table class="w-full divide-y divide-gray-200 admin-table">
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
                                            <td class="px-2 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-xs font-medium text-gray-700">
                                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-2">
                                                        <div class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($user->user_type === 'farmaceuta') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                                    {{ $user->user_type === 'farmaceuta' ? 'Farmaceuta' : 'Technik' }}
                                                </span>
                                            </td>
                                            <td class="px-2 py-4">
                                                @if($user->is_admin)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Admin
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Użytk.
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-2 py-4 text-center text-sm text-gray-900">
                                                {{ $user->certificates->count() }}
                                            </td>
                                            <td class="px-2 py-4 text-sm text-gray-500">
                                                {{ $user->created_at->format('d.m.Y') }}
                                            </td>
                                            <td class="px-2 py-4 text-sm font-medium text-center">
                                                <a href="{{ route('admin.users.progress', $user) }}" class="table-button view" title="Zobacz postępy">
                                                    Postępy
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="table-button view">
                                                    Edytuj
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Czy na pewno chcesz usunąć użytkownika {{ addslashes($user->name) }}?');">
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

                        <div class="pagination-info">
                            <div class="pagination-stats">
                                <strong>Łącznie:</strong> {{ $users->total() }} użytkowników |
                                <strong>Strona:</strong> {{ $users->currentPage() }} z {{ $users->lastPage() }} |
                                <strong>Pokazano:</strong> {{ $users->firstItem() }}-{{ $users->lastItem() }}
                            </div>
                        </div>

                        <div class="pagination-container">
                            {{ $users->links('pagination::simple-default') }}
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
