@extends('template')

@section('title', 'Register')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
@endpush

@section('content')
<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf
    <div>
        <label for="username" class="block text-sm font-medium">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required
               class="w-full mt-1 p-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('username')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="phonenumber" class="block text-sm font-medium">Phone Number</label>
        <input type="tel" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') }}" required
               placeholder="+123 456 789 12 34"
               class="w-full mt-1 p-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('phonenumber')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" name="register" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300">Register</button>
</form>

<script>
    $(document).ready(function() {
        $("#phonenumber").inputmask({
            mask: "+9{1,4} 9{1,4} [9{1,4} [9{1,4} [9{1,4}]]]",
            greedy: false,
            clearIncomplete: true,
            showMaskOnHover: false,
            autoUnmask: true,
            definitions: {
                '9': {
                    validator: "[0-9]"
                }
            },
        });
    });
</script>
@endsection
