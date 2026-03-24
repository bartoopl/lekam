@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4 max-w-4xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edycja scenariusza</h1>

    @if($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.marketing-automation.update', $scenario) }}" class="bg-white rounded-lg shadow-sm p-6 space-y-4">
        @csrf
        @method('PUT')
        @include('admin.marketing-automation.partials.form-fields', ['scenario' => $scenario])
        <div class="pt-3">
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </div>
    </form>
</div>
@endsection
