@extends('layouts.dashboard')
@section('title','Broadcast Messages')
@section('page-title','Broadcast Messages')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Broadcast Messages</h1>
        <a href="{{ route('admin.broadcasts.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>New Broadcast
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Recipients</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Created</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($broadcasts as $broadcast)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-3 font-semibold">{{ $broadcast->title }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($broadcast->recipient_type === 'all') bg-blue-100 text-blue-800
                                @elseif($broadcast->recipient_type === 'group') bg-purple-100 text-purple-800
                                @else bg-orange-100 text-orange-800
                                @endif">
                                {{ ucfirst($broadcast->recipient_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">{{ $broadcast->recipients_count }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($broadcast->status === 'sent') bg-green-100 text-green-800
                                @elseif($broadcast->status === 'scheduled') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($broadcast->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm">{{ $broadcast->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.broadcasts.show', $broadcast) }}" class="text-blue-600 hover:underline mr-3">View</a>
                            @if($broadcast->status !== 'sent')
                                <form action="{{ route('admin.broadcasts.destroy', $broadcast) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this broadcast?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No broadcasts yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $broadcasts->links() }}
    </div>
</div>
@endsection
