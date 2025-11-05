  <!-- Copy Link -->
  <div>
    <p class="mb-2 text-sm font-semibold">Copy link to share:</p>
    <div class="flex items-center space-x-2">
      <input
        id="shareLink"
        type="text"
        class="w-full border px-3 py-2 rounded text-sm"
        value="<?= $_SERVER['REQUEST_URI']?>&share=true"
        readonly
        onclick="this.select()"
      />
      <button
        onclick="copyLink()"
        class="bg-blue-500 text-white px-3 py-2 text-sm rounded hover:bg-blue-600 transition"
      >
        Copy
      </button>
    </div>
    <p id="copyStatus" class="text-green-500 text-sm mt-1 hidden">Link copied!</p>
  </div>

  <!-- Share Buttons - Redesigned -->
<div>
  <p class="mb-2 text-sm font-semibold">Share via:</p>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
    
    <!-- Email -->
    <a href="mailto:?subject=Check this out&body=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Email</span>
    </a>

    <!-- WhatsApp -->
    <a href="https://wa.me/?text=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h2l1 2 2-2h2l1 2 2-2h2l1 2 2-2h2" />
      </svg>
      <span class="text-sm font-medium text-gray-700">WhatsApp</span>
    </a>

    <!-- Facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Facebook</span>
    </a>

    <!-- Twitter (X) -->
    <a href="https://x.com/intent/tweet?url=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M17.5 6.5L6.5 17.5M6.5 6.5L17.5 17.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="text-sm font-medium text-gray-700">X (Twitter)</span>
    </a>

    <!-- LinkedIn -->
    <a href="https://www.linkedin.com/shareArticle?url=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M16 8a6 6 0 016 6v5h-4v-5a2 2 0 00-4 0v5h-4v-9h4v1.2a4 4 0 013-1.2zM2 9h4v12H2zM4 3a2 2 0 110 4 2 2 0 010-4z" />
      </svg>
      <span class="text-sm font-medium text-gray-700">LinkedIn</span>
    </a>

    <!-- Instagram (just link to IG) -->
    <a href="https://www.instagram.com/" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
        <circle cx="12" cy="12" r="3.5" />
        <circle cx="17.5" cy="6.5" r="1" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Instagram</span>
    </a>

  </div>
</div>


  <!-- QR Code -->
  <div class="text-center mt-6">
    <p class="mb-2 text-sm font-semibold">Scan or download QR code:</p>
    <a
      href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $_SERVER['REQUEST_URI']?>&share=true"
      download="ShareQR.png"
      class="inline-block"
    >
      <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $_SERVER['REQUEST_URI']?>&share=true"
        alt="QR Code"
        class="w-40 h-40 mx-auto rounded border shadow"
      />
      <p class="text-blue-500 mt-2 hover:underline">Download Me</p>
    </a>
  </div>
  <script>
  function copyLink() {
    const input = document.getElementById('shareLink');
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');

    const status = document.getElementById('copyStatus');
    status.classList.remove('hidden');
    setTimeout(() => status.classList.add('hidden'), 2000);
  }
</script>