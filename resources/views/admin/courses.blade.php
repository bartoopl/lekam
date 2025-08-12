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

    .courses-container {
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

    .table-button.edit {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .table-button.edit:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white !important;
    }

    .table-button.delete {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        border: none;
        cursor: pointer;
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
        <h1 class="admin-title">Zarządzanie Kursami</h1>
        <a href="{{ route('admin.courses.create') }}" class="admin-quick-action">
            ➕ Dodaj nowy kurs
        </a>
    </div>

    <div class="courses-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($courses->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 admin-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tytuł
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Lekcje
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Utworzony
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Akcje
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($courses as $course)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                                                        <p class="text-sm text-gray-600">{{ Str::limit($course->description, 100) }}</p>
                                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                                            <span>{{ $course->lessons->count() }} lekcji</span>
                                                            <span>{{ $course->duration_minutes }} min</span>
                                                            <span>{{ $course->pharmacist_points }} pkt (farm.)</span>
                                                            <span>{{ $course->technician_points }} pkt (tech.)</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('admin.courses.show', $course) }}" class="table-button view text-sm">
                                                            Podgląd
                                                        </a>
                                                        <a href="{{ route('admin.courses.edit', $course) }}" class="table-button edit text-sm">
                                                            Edytuj
                                                        </a>
                                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="table-button delete text-sm" onclick="return confirm('Czy na pewno chcesz usunąć ten kurs?')">
                                                                Usuń
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($course->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                                    {{ $course->is_active ? 'Aktywny' : 'Nieaktywny' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $course->lessons->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $course->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.courses.show', $course) }}" class="table-button view">
                                                        Podgląd
                                                    </a>
                                                    <a href="{{ route('admin.courses.edit', $course) }}" class="table-button edit">
                                                        Edytuj
                                                    </a>
                                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="table-button delete" onclick="return confirm('Czy na pewno chcesz usunąć ten kurs?')">
                                                            Usuń
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak kursów</h3>
                            <p class="mt-1 text-sm text-gray-500">Nie ma jeszcze żadnych kursów w systemie.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.courses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                    Dodaj pierwszy kurs
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
