@extends('layouts.dashboard')

@section('title', 'Donations Management')
@section('page-title', 'Donations Management')

@section('topbar-actions')
<a href="{{ route('admin.donations.index') }}" class="btn btn-primary btn-sm">
  <i class="fas fa-refresh"></i> Refresh
</a>
@endsection

@section('content')
<div class="page-hd">
  <h1>Donations Management</h1>
  <p>View and manage all donations received</p>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
  <div class="stat-card">
    <div class="stat-label">Total Donations</div>
    <div class="stat-value">{{ $stats['total'] }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Completed</div>
    <div class="stat-value text-green-600">{{ $stats['completed'] }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Processing</div>
    <div class="stat-value text-blue-600">{{ $stats['processing'] }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Failed</div>
    <div class="stat-value text-red-600">{{ $stats['failed'] }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Amount</div>
    <div class="stat-value">£{{ number_format($stats['total_amount'], 2) }}</div>
  </div>
</div>

<!-- Filters -->
<div class="card mb-6">
  <form method="GET" action="{{ route('admin.donations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <input type="text" name="search" class="form-input" placeholder="Search by email..." value="{{ request('search') }}">
    </div>
    <div>
      <select name="status" class="form-input">
        <option value="">All Statuses</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
      </select>
    </div>
    <div>
      <button type="submit" class="btn btn-primary w-full">Filter</button>
    </div>
    <div>
      <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary w-full">Clear</a>
    </div>
  </form>
</div>

<!-- Donations Table -->
<div class="card overflow-x-auto">
  <table class="w-full">
    <thead class="bg-gray-50 border-b border-gray-200">
      <tr>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
          <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-900">
            ID
          </a>
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
          <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['sort_by' => 'donor_email', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-900">
            Email
          </a>
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
          <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['sort_by' => 'amount', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-900">
            Amount
          </a>
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
          <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['sort_by' => 'status', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-900">
            Status
          </a>
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Payment ID</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
          <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-900">
            Date
          </a>
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      @forelse($donations as $donation)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 text-sm text-gray-900">#{{ $donation->id }}</td>
          <td class="px-6 py-4 text-sm text-gray-900">{{ $donation->donor_email ?? $donation->email ?? 'N/A' }}</td>
          <td class="px-6 py-4 text-sm font-semibold text-gray-900">£{{ number_format($donation->amount, 2) }}</td>
          <td class="px-6 py-4 text-sm">
            @if($donation->status === 'completed')
              <span class="badge badge-green">Completed</span>
            @elseif($donation->status === 'processing')
              <span class="badge badge-blue">Processing</span>
            @elseif($donation->status === 'failed')
              <span class="badge badge-red">Failed</span>
            @else
              <span class="badge badge-gray">{{ ucfirst($donation->status) }}</span>
            @endif
          </td>
          <td class="px-6 py-4 text-sm text-gray-500">
            <small>{{ substr($donation->stripe_payment_id ?? 'N/A', 0, 20) }}...</small>
          </td>
          <td class="px-6 py-4 text-sm text-gray-900">{{ $donation->created_at->format('d M Y H:i') }}</td>
          <td class="px-6 py-4 text-sm">
            <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-sm btn-primary">View</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="px-6 py-8 text-center text-gray-500">No donations found</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="mt-6 flex justify-center">
  {{ $donations->links() }}
</div>
@endsection
