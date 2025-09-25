@props(['course'])

@if($course->has_instruction && $course->instruction_content)
<!-- Instruction Modal -->
<div id="instructionModal" class="fixed inset-0 hidden" style="backdrop-filter: blur(2px); z-index: 1100;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[80vh] overflow-y-auto shadow-xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Instrukcja</h3>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors duration-200" onclick="closeInstructionModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($course->instruction_content)) !!}
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end p-6 border-t border-gray-200">
                <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200" onclick="closeInstructionModal()">
                    Zamknij
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #1f2937;
    font-weight: 600;
    margin-top: 1.5em;
    margin-bottom: 0.75em;
}

.prose h1 { font-size: 1.875rem; }
.prose h2 { font-size: 1.5rem; }
.prose h3 { font-size: 1.25rem; }

.prose p {
    margin-bottom: 1em;
}

.prose strong {
    font-weight: 600;
    color: #374151;
}

.prose em {
    font-style: italic;
}

.prose ul, .prose ol {
    padding-left: 1.5rem;
    margin-bottom: 1em;
}

.prose li {
    margin-bottom: 0.5em;
}

.prose code {
    background-color: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: monospace;
    font-size: 0.875em;
}
</style>

<script>
function openInstructionModal() {
    document.getElementById('instructionModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeInstructionModal() {
    document.getElementById('instructionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('instructionModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeInstructionModal();
            }
        });
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('instructionModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeInstructionModal();
        }
    }
});
</script>
@endif