// utils/alertFunction.tsx
import Swal, { SweetAlertIcon } from 'sweetalert2';

export const showAlert = (id: number, type: string, message: string) => {
    const alertType: SweetAlertIcon = type as SweetAlertIcon;
    Swal.fire({
        title: message,
        icon: alertType,
        showConfirmButton: false,
        timer: 3000,
        position: 'top-end',
        toast: true,
        padding: '10px 20px',
    });
};
