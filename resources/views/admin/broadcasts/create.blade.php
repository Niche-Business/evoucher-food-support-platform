@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-8">Create Broadcast Message</h1>

    <form action="{{ route('admin.broadcasts.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Title</label>
            <input type="text" name="title" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Broadcast title">
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Message</label>
            <textarea name="message" required rows="6" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Your message here..."></textarea>
            @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Send To</label>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="radio" name="recipient_type" value="all" checked class="mr-2">
                    <span>All Users</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="recipient_type" value="group" class="mr-2">
                    <span>Specific Role</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="recipient_type" value="individual" class="mr-2">
                    <span>Individual Users</span>
                </label>
            </div>
        </div>

        <div id="role-select" class="mb-6 hidden">
            <label class="block text-sm font-semibold mb-2">Select Role</label>
            <select name="recipient_role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">-- Select Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Schedule (Optional)</label>
            <input type="datetime-local" name="scheduled_at" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            <small class="text-gray-600">Leave empty to send immediately</small>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Create Broadcast</button>
            <a href="{{ route('admin.broadcasts.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('input[name="recipient_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('role-select').classList.toggle('hidden', this.value !== 'group');
        });
    });
</script>
@endsection
