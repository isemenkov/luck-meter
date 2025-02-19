<form method="POST" action="{{ route('last-results') }}" class="space-y-4">
    @csrf
    <div class="space-y-4 p-4 bg-gray-700 rounded-lg">
        <button type="submit" name="showHistory" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300">Show History</button>
        @if(!empty($historyResults))
        <div class="mt-4 p-4 bg-gray-700 rounded-lg text-center">
            <p class="text-xl pb-5">Last Three Results:</p>
            <ul id="history" class="list-disc list-inside text-lg text-left">
            @foreach($historyResults as $result)
                <li>{{ $result['score'] }} &nbsp;<span class="text-sm text-gray-400">{{ $result['time'] }}</span></li>
            @endforeach
            </ul>
        </div>
        @endif
    </div>
</form>
