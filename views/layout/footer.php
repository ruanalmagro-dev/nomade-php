<?php
$local_js_path = 'assets/js/bootstrap.bundle.min.js';
$bootstrap_js = file_exists($local_js_path) ? $local_js_path : 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
?>

</main>
<footer class="bg-primary text-white text-center py-4 mt-auto">
    <div class="container"><p class="mb-0">&copy; 2025 Nomade Travels</p></div>
</footer>
<script src="<?= $bootstrap_js ?>"></script>
<script>
         document.addEventListener('DOMContentLoaded', function () {
                 const detailModalElement = document.getElementById('modalPropertyDetail');
                 const detailModal = new bootstrap.Modal(detailModalElement);
                 const modalContentContainer = document.querySelector('#modalPropertyDetail .modal-content-container');

               document.querySelectorAll('.btn-view-detail').forEach(button => {
                     button.addEventListener('click', function () {
                             const propertyId = this.getAttribute('data-id');

                                modalContentContainer.innerHTML = '<div class="modal-content"><div class="modal-body text-center p-5">Carregando detalhes...</div></div>';
                detailModal.show();

                                fetch(`detalhes?id=${propertyId}`)
                                        .then(response => {
                                                if (!response.ok) {
                                                        throw new Error('Imóvel não encontrado ou erro de servidor.');
                                                }
                                                return response.text();
                                        })
                                        .then(html => {
                                        modalContentContainer.innerHTML = html;
                                                
                        const modalHeader = modalContentContainer.querySelector('.modal-header');
                        if (modalHeader) {
                            const closeButton = document.createElement('button');
                            closeButton.setAttribute('type', 'button');
                            closeButton.setAttribute('class', 'btn-close');
                            closeButton.setAttribute('data-bs-dismiss', 'modal');
                            modalHeader.appendChild(closeButton);
                        }
                        
                                        })
                        .catch(error => {
                        console.error('Fetch Error:', error);
                        modalContentContainer.innerHTML = `<div class="modal-content"><div class="alert alert-danger p-3">${error.message}</div></div>`;
            });
        });
    });
});
</script>
</body>
</html>