<form method="POST" action="{{ route('luck-calculator') }}" class="space-y-4">
    @csrf
    <div class="space-y-4 p-4 bg-gray-700 rounded-lg">
        <button type="submit" name="lucky" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 text-xl rounded-lg shadow-lg transition duration-300">I am feeling lucky</button>
        <div class="mt-4 p-4 bg-gray-700 rounded-lg text-center">
            <p class="text-xl">Current Score: <span id="score">{{ $score }}</span></p>
        </div>
    </div>
</form>
