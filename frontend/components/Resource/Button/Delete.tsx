import React, { useState } from 'react';
import IconTrashLines from '@/components/Icon/IconTrashLines';
import Tippy from '@tippyjs/react';
import 'tippy.js/dist/tippy.css';
import { getCookie } from 'cookies-next';
import Swal from 'sweetalert2';

interface DeleteProps {
    URL: string; // Tipe URL diubah menjadi string
    id: string; // Tipe id diubah menjadi string
    onDeleteSuccess: () => void;
}

const Delete: React.FC<DeleteProps> = ({ URL, id, onDeleteSuccess }) => {
    const accessToken = getCookie('access_token');
    const [isLoading, setIsLoading] = useState(false);

    const confirmDelete = () => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                deleteResource();
            }
        });
    };

    const deleteResource = async () => {
        setIsLoading(true);
        try {
            const response = await fetch(`${URL}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                },
            });

            const data = await response.json();

            if (response.ok) {
                Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                onDeleteSuccess();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'An error occurred while deleting the resource.',
                });
            }
        } catch (error) {
            console.error('Error during deletion:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.',
            });
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <>
            <Tippy content="Delete">
                <button onClick={confirmDelete} disabled={isLoading}>
                    <IconTrashLines className="text-danger" />
                </button>
            </Tippy>
        </>
    );
};

export default Delete;
