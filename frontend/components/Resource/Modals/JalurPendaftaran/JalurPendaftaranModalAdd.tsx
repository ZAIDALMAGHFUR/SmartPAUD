import { useState, Fragment, useEffect } from 'react';
import IconX from '@/components/Icon/IconX';
import { Dialog, Transition } from '@headlessui/react';
import Tippy from '@tippyjs/react';
import 'tippy.js/dist/tippy.css';
import Swal, { SweetAlertIcon } from 'sweetalert2';
import { tsrs2000 } from '@/services/apiUtils';

interface provinsi {
    id: string;
    name: string;
}
interface kabupaten {
    id: string;
    name: string;
}
interface kecamatan {
    id: string;
    name: string;
}
interface kelurahan {
    id: string;
    name: string;
}

interface FormData {
    dpt: string;
    provinsi_id: string;
    kabupaten_id: string;
    kecamatan_id: string;
    kelurahan_id: string;
}

export default function DPTModalAdd() {
    const [isClient, setIsClient] = useState(false);
    useEffect(() => {
        setIsClient(true);
    }, []);

    const [modal20, setModal20] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [provinsi, setProvinsi] = useState<provinsi[]>([]);
    const [kabupaten, setKabupaten] = useState<kabupaten[]>([]);
    const [kecamatan, setKecamatan] = useState<kecamatan[]>([]);
    const [kelurahan, setKelurahan] = useState<kelurahan[]>([]);
    const [userData, setUserData] = useState({
        kdprofile:'1',
        statusenabled:'1',
        provinsi_id: '',
        kabupaten_id: '',
        kecamatan_id: '',
        kelurahan_id: '',
        dpt:''
    });

    // useEffect(() => {
    //     const fetchData = async () => {
    //         try {
    //             setIsLoading(true);
    //             const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/data-combo`, 'Data Combo');
    //             // setGender(response.data.gender);
    //             // setCitizens(response.data.citizen);
    //             // setWorkUnits(response.data.work_units);
    //         } catch (error) {
    //             console.error('Error fetching combo data:', error);
    //         } finally {
    //             setIsLoading(false);
    //         }
    //     };

    //     fetchData();
    //     fetchProvinsi();
    // }, []);

    const fetchProvinsi = async () => {
        try {
            setIsLoading(true);
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/provinces`, 'Data provinces');
            setProvinsi(response.data);
            const defaultProvinsiId = response.data.find((prov: provinsi) => prov.name === 'Jawa Barat')?.id || ''; // Ubah sesuai dengan kondisi Anda
            setUserData(prevState => ({ ...prevState, provinsi_id: defaultProvinsiId }));
            fetchKabupaten(defaultProvinsiId);
        } catch (error) {
            console.error('Error fetching combo data:', error);
        } finally {
            setIsLoading(false);
        }
    };

    const fetchKabupaten = async (provinsiId: string) => {
        try {
            setIsLoading(true);
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/provinces/${provinsiId}/kabupatens`, 'Data kabupatens');
            setKabupaten(response.data);
            const defaultKabupatenId = response.data.find((kab: kabupaten) => kab.name === 'Bogor')?.id || ''; // Ubah sesuai dengan kondisi Anda
            setUserData(prevState => ({ ...prevState, kabupaten_id: defaultKabupatenId }));
            fetchKecamatan(defaultKabupatenId);
        } catch (error) {
            console.error('Error fetching combo data:', error);
        } finally {
            setIsLoading(false);
        }
    }

    const fetchKecamatan = async (kabupatenId: string) => {
        try {
            setIsLoading(true);
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/kabupatens/${kabupatenId}/kecamatans`, 'Data kecamatans');
            setKecamatan(response.data);
            fetchKelurahan(response.data.kecamatan[0].id);
        } catch (error) {
            console.error('Error fetching combo data:', error);
        } finally {
            setIsLoading(false);
        }
    }

    const fetchKelurahan = async (kecamatanId: string) => {
        try {
            setIsLoading(true);
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/kecamatans/${kecamatanId}/kelurahans`, 'Data kelurahans');
            setKelurahan(response.data);
        } catch (error) {
            console.error('Error fetching combo data:', error);
        } finally {
            setIsLoading(false);
        }
    }

    const handleProvinsiChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const provinsiId = e.target.value;
        fetchKabupaten(provinsiId);
    };

    const handleKabupatenChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const kabupatenId = e.target.value;
        fetchKecamatan(kabupatenId);
    };

    const handleKecamatanChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const kecamatanId = e.target.value;
        fetchKelurahan(kecamatanId);
    };

    const handleCreateFormSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setIsLoading(true);
        // const formData = { ...userData };
        const form = e.currentTarget as HTMLFormElement & {
            elements: {
                dpt: HTMLInputElement;
                provinsi_id: HTMLSelectElement;
                kabupaten_id: HTMLSelectElement;
                kecamatan_id: HTMLSelectElement;
                kelurahan_id: HTMLSelectElement;
            };
        };

        const formData: FormData = {
            dpt: form.elements.dpt.value,
            provinsi_id: form.elements.provinsi_id.value,
            kabupaten_id: form.elements.kabupaten_id.value,
            kecamatan_id: form.elements.kecamatan_id.value,
            kelurahan_id: form.elements.kelurahan_id.value,
        };
        try {
            const response = await tsrs2000.post(`${process.env.NEXT_PUBLIC_API_BASE_URL}/dpt`, formData, 'Create Jumlah DPT');
            setUserData({
                kdprofile:'1',
                statusenabled:'1',
                provinsi_id: '',
                kabupaten_id: '',
                kecamatan_id: '',
                kelurahan_id: '',
                dpt:''
            })
            setTimeout(() => {
                setModal20(false);
            }, 1000);
        } catch (error) {
            console.error('Error handling form submission:', error);
        } finally {
            setIsLoading(false);
        }
    };

    const showAlert = (icon: SweetAlertIcon, title: string) => {
        Swal.fire({
            icon,
            title,
            showConfirmButton: false,
            timer: 3000,
            position: 'top-end',
            toast: true,
            padding: '10px 20px',
        });
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setUserData({ ...userData, [name]: value });
    };

    const handleClick = () => {
        setModal20(true);
        fetchProvinsi();
    };

    if (!isClient) {
        return null; // Atau pengganti loading state lainnya
    }

    return (
        <div>
            {/* <Tippy content="Tambah">

            </Tippy> */}

            <button type="button" onClick={handleClick}>
                <div className='mt-6'>
                    <button type="button" className="btn btn-info">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            className="bi bi-plus mr-2"
                            viewBox="0 0 16 16"
                        >
                            <path d="M8 8V1a1 1 0 0 1 2 0v7h7a1 1 0 0 1 0 2H10v7a1 1 0 0 1-2 0V10H1a1 1 0 0 1 0-2h7z"/>
                        </svg>
                        Tambah
                    </button>
                </div>
            </button>
            <Transition appear show={modal20} as={Fragment}>
                <Dialog as="div" open={modal20} onClose={() => setModal20(false)} className="relative z-50">
                    <Transition.Child
                        as={Fragment}
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <Dialog.Overlay className="fixed inset-0 bg-[black]/60" />
                    </Transition.Child>

                    <div className="fixed inset-0 overflow-y-auto">
                        <div className="flex min-h-full items-center justify-center px-4 py-8">
                            <Transition.Child
                                as={Fragment}
                                enter="duration-300 ease-out"
                                enter-from="opacity-0 scale-95"
                                enter-to="opacity-100 scale-100"
                                leave="duration-200 ease-in"
                                leave-from="opacity-100 scale-100"
                                leave-to="opacity-0 scale-95"
                            >
                                <Dialog.Panel className="panel w-full max-w-lg overflow-hidden rounded-lg border-0 p-0 text-black dark:text-white-dark">
                                    <button type="button" className="absolute top-4 text-gray-400 outline-none hover:text-gray-800 ltr:right-4 rtl:left-4 dark:hover:text-gray-600" onClick={() => setModal20(false)} >
                                        <IconX />
                                    </button>
                                    <div className="bg-[#fbfbfb] py-3 text-lg font-medium ltr:pl-5 ltr:pr-[50px] rtl:pr-5 rtl:pl-[50px] dark:bg-[#121c2c]">
                                        Tambah Jumlah DPT
                                    </div>
                                    <div className="pt-5">
                                        <form className="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-black" onSubmit={handleCreateFormSubmit}>
                                            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                                <div>
                                                    <label htmlFor="provinsi_id">Provinsi</label>
                                                    <select id="provinsi_id" name="provinsi_id" value={userData.provinsi_id} onChange={handleProvinsiChange} className="form-select" disabled>
                                                        <option value="">Provinsi</option>
                                                        {provinsi.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="kabupaten_id">Kabupaten</label>
                                                    <select id="kabupaten_id" name="kabupaten_id" value={userData.kabupaten_id} onChange={handleKabupatenChange} className="form-select" disabled>
                                                        <option value="">Kabupaten</option>
                                                        {kabupaten.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="kecamatan_id">Kecamatan</label>
                                                    <select id="kecamatan_id" name="kecamatan_id" onChange={handleKecamatanChange} className="form-select">
                                                        <option value="">Kecamatan</option>
                                                        {kecamatan.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="kelurahan_id">Kelurahan</label>
                                                    <select id="kelurahan_id" name="kelurahan_id" className="form-select">
                                                        <option value="">Kelurahan</option>
                                                        {kelurahan.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                            </div>
                                            <div className='mt-5'>
                                                <label htmlFor="dpt">Jumlah DPT</label>
                                                <input id="dpt" name="dpt" type="text" value={userData.dpt} onChange={handleChange} placeholder="Jumlah DPT" className="form-input" />
                                            </div>
                                            <div className="mt-6 flex items-center justify-end">
                                                <button type="submit" className="btn btn-primary">
                                                    {isLoading ? 'Adding...' : 'Tambah Data'}
                                                </button>
                                                <button type="button" className="btn btn-secondary ml-3" onClick={() => setModal20(false)}>
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </Dialog.Panel>
                            </Transition.Child>
                        </div>
                    </div>
                </Dialog>
            </Transition>
        </div>
    );
}
