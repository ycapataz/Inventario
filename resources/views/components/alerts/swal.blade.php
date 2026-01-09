<di>
    <script>
        document.addEventListener('livewire:load', () => {

            Livewire.on('alert', (data) => {
                Swal.fire({
                    icon: data.type ?? 'info',
                    title: data.title ?? '',
                    text: data.message ?? '',
                    timer: data.timer ?? null,
                    showConfirmButton: data.confirm ?? true,
                })
            })

            Livewire.on('confirm', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: data.title ?? '¿Estás seguro?',
                    text: data.message ?? '',
                    showCancelButton: true,
                    confirmButtonText: data.confirmText ?? 'Sí',
                    cancelButtonText: data.cancelText ?? 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Llama al método público de tu componente Livewire
                        Livewire.emit('runAction', data.action, data.params ?? {})
                    }
                })
            })
        })
    </script>

</di>
