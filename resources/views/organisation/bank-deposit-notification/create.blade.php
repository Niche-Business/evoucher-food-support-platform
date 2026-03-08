@extends('layouts.dashboard')

@section('title', 'Submit Bank Deposit - eVoucher Platform')

@section('content')
<div class="page-header mb-6">
  <h1>Bank Deposit Notification</h1>
  <p>Submit your bank deposit details for admin verification and fund loading.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <!-- Left Column: Form -->
  <div class="card">
    <div class="card-body">
      <form action="{{ route($role === 'vcfse' ? 'vcfse.bank-deposit-notification.store' : 'school.bank-deposit-notification.store') }}" method="POST" enctype="multipart/form-data" id="bankDepositForm">
        @csrf

        <!-- Deposit Amount -->
        <div class="mb-6">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Deposit Amount (£) <span class="text-red-500">*</span></label>
          <input type="number" name="amount" step="0.01" min="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('amount') border-red-500 @enderror" placeholder="e.g., 5000" value="{{ old('amount') }}" required>
          @error('amount')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Bank Reference/Transaction ID -->
        <div class="mb-6">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Bank Reference/Transaction ID <span class="text-red-500">*</span></label>
          <input type="text" name="reference" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('reference') border-red-500 @enderror" placeholder="e.g., TRF-20260307-001" value="{{ old('reference') }}" required>
          <p class="text-gray-500 text-xs mt-1">Unique identifier for tracking this transfer</p>
          @error('reference')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Bank Details Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
          <h3 class="font-semibold text-gray-800 mb-4">Bank Details</h3>

          <!-- Bank Name -->
          <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Bank Name <span class="text-red-500">*</span></label>
            <input type="text" name="bank_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('bank_name') border-red-500 @enderror" placeholder="e.g., Barclays, HSBC, Lloyds" value="{{ old('bank_name') }}" required>
            @error('bank_name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Account Holder Name -->
          <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Account Holder Name <span class="text-red-500">*</span></label>
            <input type="text" name="bank_account_holder" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('bank_account_holder') border-red-500 @enderror" placeholder="e.g., Northampton Community Trust" value="{{ old('bank_account_holder') }}" required>
            @error('bank_account_holder')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Sort Code -->
          <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Code <span class="text-red-500">*</span></label>
            <input type="text" name="sort_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('sort_code') border-red-500 @enderror" placeholder="XX-XX-XX" pattern="\d{2}-\d{2}-\d{2}" value="{{ old('sort_code') }}" required>
            <p class="text-gray-500 text-xs mt-1">Format: XX-XX-XX (e.g., 20-17-75)</p>
            @error('sort_code')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Account Number -->
          <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Account Number <span class="text-red-500">*</span></label>
            <input type="text" name="account_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('account_number') border-red-500 @enderror" placeholder="8 digits" pattern="\d{8}" maxlength="8" value="{{ old('account_number') }}" required>
            <p class="text-gray-500 text-xs mt-1">8 digit account number</p>
            @error('account_number')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Notes -->
        <div class="mb-6">
          <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Notes</label>
          <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('notes') border-red-500 @enderror" placeholder="Add any additional information about this deposit...">{{ old('notes') }}</textarea>
          @error('notes')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Hidden Receipt Input -->
        <input type="file" name="receipt" id="receipt-input" class="hidden" accept=".pdf,.png,.jpg,.jpeg">

        <!-- Submit Button -->
        <div class="flex gap-3">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-check"></i> Submit Bank Deposit
          </button>
          <a href="{{ route($role === 'vcfse' ? 'vcfse.dashboard' : 'school.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Right Column: Receipt Upload -->
  <div class="card">
    <div class="card-body">
      <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fas fa-receipt text-green-600"></i>
        Bank Receipt/Proof of Transfer
      </h3>
      <p class="text-gray-600 text-sm mb-4">Upload your bank receipt or proof of transfer for verification. This helps us verify your deposit faster.</p>

      <!-- Receipt Drop Zone -->
      <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-green-500 hover:bg-green-50 transition" id="receipt-drop-zone">
        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
        <p class="text-gray-600 font-medium mb-1">Drag and drop your receipt</p>
        <p class="text-gray-500 text-xs mb-4">or click to browse</p>
        <p class="text-gray-400 text-xs">Supported formats: PDF, PNG, JPG, JPEG</p>
        <p class="text-gray-400 text-xs">Maximum size: 5MB</p>
      </div>

      <!-- Receipt Preview -->
      <div id="receipt-preview" class="mt-4 hidden">
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg">
          <i class="fas fa-file-check text-green-600 text-2xl"></i>
          <div class="flex-1 text-left">
            <p class="font-medium text-gray-800" id="receipt-filename"></p>
            <p class="text-xs text-gray-600" id="receipt-size"></p>
          </div>
          <button type="button" id="receipt-remove" class="text-red-600 hover:text-red-800 text-lg">
            <i class="fas fa-times-circle"></i>
          </button>
        </div>
      </div>

      <!-- Info Box -->
      <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-sm text-gray-700">
          <i class="fas fa-info-circle text-blue-600 mr-2"></i>
          <strong>Optional:</strong> You can submit the form without a receipt. We'll verify your deposit using the bank details you provide.
        </p>
      </div>

      <!-- Error Message -->
      @error('receipt')
        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}</p>
        </div>
      @enderror
    </div>
  </div>
</div>

<style>
.grid { display: grid; }
.grid-cols-1 { grid-template-columns: 1fr; }
.gap-6 { gap: 24px; }

@media (min-width: 1024px) {
  .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-primary {
  background: #16a34a;
  color: white;
}

.btn-primary:hover {
  background: #15803d;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.btn-secondary {
  background: #f1f5f9;
  color: #334155;
  border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
  background: #e2e8f0;
}

.hidden {
  display: none;
}
</style>

<script>
  const dropZone = document.getElementById('receipt-drop-zone');
  const receiptInput = document.getElementById('receipt-input');
  const receiptPreview = document.getElementById('receipt-preview');
  const receiptFilename = document.getElementById('receipt-filename');
  const receiptSize = document.getElementById('receipt-size');
  const receiptRemove = document.getElementById('receipt-remove');

  // Click to upload
  dropZone.addEventListener('click', () => receiptInput.click());

  // File selection
  receiptInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      displayFile(file);
    }
  });

  // Drag and drop
  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = '#16a34a';
    dropZone.style.backgroundColor = '#dcfce7';
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#d1d5db';
    dropZone.style.backgroundColor = 'transparent';
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = '#d1d5db';
    dropZone.style.backgroundColor = 'transparent';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      const file = files[0];
      if (validateFile(file)) {
        receiptInput.files = files;
        displayFile(file);
      }
    }
  });

  // Remove file
  receiptRemove.addEventListener('click', (e) => {
    e.preventDefault();
    receiptInput.value = '';
    receiptPreview.classList.add('hidden');
  });

  function validateFile(file) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];
    
    if (file.size > maxSize) {
      alert('File size must be less than 5MB');
      return false;
    }
    
    if (!allowedTypes.includes(file.type)) {
      alert('Only PDF, PNG, and JPEG files are allowed');
      return false;
    }
    
    return true;
  }

  function displayFile(file) {
    receiptFilename.textContent = file.name;
    receiptSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
    receiptPreview.classList.remove('hidden');
  }
</script>
@endsection
