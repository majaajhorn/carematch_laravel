@extends('layouts.master')

@section('content')

  <div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Apply for Job</h1>

    {{-- Flash messages --}}
    @if (session('success'))
      <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
        {{ session('error') }}
      </div>
    @endif

    {{-- Validation summary --}}
    @if ($errors->any())
      <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
        <ul class="list-disc space-y-1 pl-6 text-sm text-red-700">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Job summary --}}
    <div class="mb-8 rounded-xl border border-gray-200 bg-gray-50 p-5">
      <h2 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h2>
      <div class="mt-3 flex flex-wrap gap-3 text-sm text-gray-700">
        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">📍 {{ $job->location }}</span>
        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">💰 £{{ $job->salary }}
          {{ (string) $job->salary_period }}</span>
        <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-blue-800">
          {{ ucfirst(str_replace('_', ' ', (string) $job->employment_type)) }}
        </span>
        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">
          Posted {{ optional($job->created_at)->diffForHumans() }}
        </span>
      </div>
    </div>

    {{-- Application form --}}
    <form method="POST" action="{{ route('applications.store', $job) }}" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div>
        <label for="cover_letter" class="mb-2 block font-medium text-gray-800">
          Cover Letter <span class="text-red-600">*</span>
        </label>
        <textarea id="cover_letter" name="cover_letter" rows="8"
          placeholder="Introduce yourself and explain why you're interested in this position..."
          class="w-full rounded-lg border  p-3 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('cover_letter') border-red-400 ring-1 ring-red-400 @enderror">{{ old('cover_letter') }}</textarea>
        @error('cover_letter')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="additional_notes" class="mb-2 block font-medium text-gray-800">Additional Notes</label>
        <textarea id="additional_notes" name="additional_notes" rows="4"
          placeholder="Any other information you'd like to share with the employer..."
          class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('additional_notes') }}</textarea>
      </div>

      <div>
        <label for="resume" class="mb-2 block font-medium text-gray-800">Resume/CV <span
            class="text-red-600">*</span></label>
        <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx"
          class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-gray-700 hover:file:bg-gray-200" />
        @error('resume')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</p>
      </div>

      <div>
        <label class="flex items-start gap-3">
          <input id="confirmed" type="checkbox" name="confirmed" value="1"
            class="mt-1 h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ old('confirmed') ? 'checked' : '' }} />
          <span class="text-sm text-gray-800">
            I confirm that all information provided is accurate and complete
            <span class="text-red-600">*</span>
          </span>
        </label>
        @error('confirmed')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex flex-col gap-3 sm:flex-row">
        <a href="{{ url()->previous() }}"
          class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
          Cancel
        </a>
        <button type="submit"
          class="inline-flex flex-1 items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
          Submit Application
        </button>
      </div>
    </form>
  </div>
@endsection