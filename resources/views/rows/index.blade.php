@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-semibold mb-4">Импортированные данные</h1>

        @foreach ($rows as $date => $group)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Дата: {{ $date }}</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ID</th>
                        <th class="px-4 py-2 border-b">Имя</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($group as $row)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $row->excel_id }}</td>
                            <td class="px-4 py-2 border-b">{{ $row->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection
