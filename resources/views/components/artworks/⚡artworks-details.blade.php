    <script>
        document.addEventListener('livewire:navigated', initWhatsAppLink);
        document.addEventListener('DOMContentLoaded', initWhatsAppLink);

        function initWhatsAppLink() {
            const link = document.getElementById('wa-direct-link');
            if (!link) return;

            const clone = link.cloneNode(true);
            link.parentNode.replaceChild(clone, link);

            clone.addEventListener('click', function(e) {
                e.preventDefault();
                const number = @json(config('services.whatsapp.admin_number'));
                // Get the artwork title from the page content
                const title = document.querySelector('h2.text-3xl')?.innerText || 'Artwork';
                const text = `Hello, I would like to inquire about this artwork: ${title} at LaToecross Artelier 🎨`;
                window.open(`https://wa.me/${number}?text=${encodeURIComponent(text)}`, '_blank');
            });
        }
    </script>