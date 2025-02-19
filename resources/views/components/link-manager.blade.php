<form method="POST" action="{{ route('manage-link') }}" class="space-y-4">
    @csrf
    <div class="space-y-4 p-4 bg-gray-700 rounded-lg">
        <button type="submit" name="generateNewLink" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300">Generate New Link</button>
        <div class="mt-4 p-3 bg-gray-600 rounded-lg relative">
            <div class="flex items-center gap-2 pr-2">
                <p class="text-xl flex-1 w-5/6">
                    <span id="newLink" class="block text-nowrap overflow-x-scroll pb-4">{{ $pageUrl }}</span>
                </p>
                <button id="copyButton" class="w-1/6 bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded shrink-0">Copy</button>
            </div>
        </div>
        <button type="submit" name="deactivateCurrentLink" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300">Deactivate Current Link</button>
    </div>
</form>

<script>
    const copyButton = document.getElementById('copyButton');

    copyButton.addEventListener('click', async (e) => {
        e.preventDefault();

        const newLink = document.getElementById('newLink');
        const content = newLink.textContent;
        await navigator.clipboard.writeText(content);

        const hint = document.createElement('div');
        hint.textContent = 'Copied!';
        hint.style.cssText = `
            position: fixed;
            top: 20px;
            background: #333;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s;
        `;

        document.body.appendChild(hint);

        const rect = newLink.getBoundingClientRect();
        hint.style.top = `${rect.top + window.scrollY - rect.height - 6}px`;

        setTimeout(() => hint.style.opacity = '1', 10);
        setTimeout(() => {
            hint.style.opacity = '0';
            setTimeout(() => hint.remove(), 300);
        }, 2000);
    });
</script>
