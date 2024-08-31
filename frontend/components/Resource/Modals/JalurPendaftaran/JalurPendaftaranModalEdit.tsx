import { useState, Fragment, useEffect } from 'react';
import sortBy from 'lodash/sortBy';
import IconX from '@/components/Icon/IconX';
import { Dialog, Transition } from '@headlessui/react';
import Tippy from '@tippyjs/react';
import 'tippy.js/dist/tippy.css';
import IconPencil from '@/components/Icon/IconPencil';
import Swal, { SweetAlertIcon } from 'sweetalert2';
import { getCookie } from 'cookies-next';
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

interface JumlahDPT {
    id: any,
    kdprofile: number,
    statusenabled: boolean,
    provinsi: provinsi;
    kabupaten: kabupaten;
    kecamatan: kecamatan;
    dpt: string,

}

export default function DPTModalEdit({ id }: { id: string }) {
    const [rowData, setRowData] = useState<JumlahDPT[]>([]);
    const [initialRecords, setInitialRecords] = useState<JumlahDPT[]>(sortBy(rowData, 'id'));
    const [recordsData, setRecordsData] = useState<JumlahDPT[]>(initialRecords);
    const [modal20, setModal20] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [provinsi, setProvinsi] = useState<provinsi[]>([]);
    const [kabupaten, setKabupaten] = useState<kabupaten[]>([]);
    const [kecamatan, setKecamatan] = useState<kecamatan[]>([]);
    const [kelurahan, setKelurahan] = useState<kelurahan[]>([]);
    const [dptData, setDptData] = useState({
        provinsi_id: '',
        kabupaten_id: '',
        kecamatan_id: '',
        kelurahan_id: '',
        dpt: '',
    });

    useEffect(() => {
        const fetchData = async () => {
            try {
                const accessToken = getCookie('access_token');

                if (!accessToken) {
                    throw new Error('Access token is missing');
                }

                setIsLoading(true);

                if (id) {
                    try {
                        const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/dpt/${id}`, 'Show DPT');
                        const dpt = response.data;
                        setDptData({
                            dpt: dpt.dpt,
                            provinsi_id: dpt.provinsi_id.toString(),
                            kabupaten_id: dpt.kabupaten_id.toString(),
                            kecamatan_id: dpt.kecamatan_id.toString(),
                            kelurahan_id: dpt.kelurahan_id.toString(),
                        });

                        fetchKabupaten(dpt.provinsi_id.toString())
                        fetchKecamatan(dpt.kabupaten_id.toString())
                        fetchKelurahan(dpt.kecamatan_id.toString())

                    } catch (error) {
                        console.error('Error fetching supporters data:', error);
                    } finally {
                        setIsLoading(false);
                    }
                }

                // try {
                //     const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/data-combo`, 'Data Combo');
                //     setGender(response.data.gender);
                //     setWorkUnits(response.data.work_units);
                //     setCitizen(response.data.citizen);
                // } catch (error) {
                //     console.error('Error fetching data combo:', error);
                // } finally {
                //     setIsLoading(false);
                // }
            } catch (error) {
                console.error('Error fetching data:', error);
            } finally {
                setIsLoading(false);
            }
        };

        if (modal20 && id) {
            fetchData();
            fetchProvinsi();
        }
    }, [modal20, id]);

    const fetchProvinsi = async () => {
        try {
            setIsLoading(true);
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/provinces`, 'Data provinces');
            setProvinsi(response.data);
            fetchKabupaten(response.data.provinsi[0].id);
            // console.log(response.data.provinsi);
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
            fetchKecamatan(response.data.kabupaten[0].id);
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

    const handleSearchClick = async () => {
        try {
            setIsLoading(true);
            // if (!startDate || !endDate) {
            //     showAlert('error', 'Date is required');
            //     return;
            // }
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/dpt`, 'Jumlah DPT');
            setRowData(response.data);
            const sortedData = sortBy(response.data, 'id');
            setInitialRecords(sortedData);
            setRecordsData(sortedData);
        } catch (error) {
            console.error('Error handling form submission:', error);
        } finally {
            setIsLoading(false);
        }

    };

    const handleProvinsiChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const provinsiId = e.target.value;
        fetchKabupaten(provinsiId);
        handleChange(e);
    };

    const handleKabupatenChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const kabupatenId = e.target.value;
        fetchKecamatan(kabupatenId);
        handleChange(e);
    };

    const handleKecamatanChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const kecamatanId = e.target.value;
        fetchKelurahan(kecamatanId);
        handleChange(e);
    };

    const handleKelurahanChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const kelurahanId = e.target.value;
        handleChange(e);
    };


    const handleEditFormSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setIsLoading(true);
        const formData = { ...dptData };
        try {
            const response = await tsrs2000.put(`${process.env.NEXT_PUBLIC_API_BASE_URL}/dpt/${id}`, formData, 'Edit DPT');
            setModal20(false);
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
        setDptData({ ...dptData, [name]: value });
    };

    return (
        <div>
            <Tippy content="Edit">
                <button type="button" onClick={() => setModal20(true)}>
                    <IconPencil className="text-success" />
                </button>
            </Tippy>

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
                                        Edit Jumlah DPT
                                    </div>
                                    <div className="pt-5">
                                        <form className="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-black" onSubmit={handleEditFormSubmit}>
                                            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                            <div>
                                                    <label htmlFor="provinsi_id">Provinsi</label>
                                                    <select id="provinsi_id" name="provinsi_id" value={dptData.provinsi_id} onChange={handleProvinsiChange} className="form-select" disabled>
                                                        <option value="">Provinsi</option>
                                                        {provinsi.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="kabupaten_id">Kabupaten</label>
                                                    <select id="kabupaten_id" name="kabupaten_id" value={dptData.kabupaten_id} onChange={handleKabupatenChange} className="form-select" disabled>
                                                        <option value="">Kabupaten</option>
                                                        {kabupaten.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="kecamatan_id">Kecamatan</label>
                                                    <select id="kecamatan_id" name="kecamatan_id" value={dptData.kecamatan_id} onChange={handleKecamatanChange} className="form-select">
                                                        <option value="">Kecamatan</option>
                                                        {kecamatan.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="kelurahan_id">Kelurahan</label>
                                                    <select id="kelurahan_id" name="kelurahan_id" value={dptData.kelurahan_id} onChange={handleKelurahanChange} className="form-select">
                                                        <option value="">Kelurahan</option>
                                                        {kelurahan.map((item) => (
                                                            <option key={item.id} value={item.id}>{item.name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                <div>
                                                    <label htmlFor="dpt">Jumlah DPT</label>
                                                    <input id="dpt" name="dpt" type="text" value={dptData.dpt} onChange={handleChange} placeholder="Jumlah DPT" className="form-input" />
                                                </div>
                                            </div>
                                            <div className="mt-6 flex items-center justify-end">
                                                <button type="submit" className="btn btn-primary" onClick={handleSearchClick}>
                                                    {isLoading ? 'Updating...' : 'Edit Data'}
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
