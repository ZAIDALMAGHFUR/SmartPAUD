import { useState, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { DataTable, DataTableSortStatus } from 'mantine-datatable';
import sortBy from 'lodash/sortBy';
import IconBell from '@/components/Icon/IconBell';
import Dropdown from '../../../components/Dropdown';
import Loaders from '../../../components/Loaders/Loaders';
import { setPageTitle } from '../../../store/themeConfigSlice';
import { IRootState } from '../../../store';
import Swal, { SweetAlertIcon } from 'sweetalert2';
import SuperAdminLayout from '@/components/Layouts/SuperAdminLayout';
import IconCaretDown from '@/components/Icon/IconCaretDown';
import { tsrs2000 } from '@/services/apiUtils';
import JalurPendaftaranModalAdd from '@/components/Resource/Modals/JalurPendaftaran/JalurPendaftaranModalAdd';
import JalurPendaftaranModalEdit from '@/components/Resource/Modals/JalurPendaftaran/JalurPendaftaranModalEdit';
import Delete from '@/components/Resource/Button/Delete';

interface JalurPendaftaran {
    id: any;
    kdprofile: number;
    statusenabled: boolean;
    name: string;
}

const Index = () => {
    const dispatch = useDispatch();
    useEffect(() => {
        dispatch(setPageTitle('Data Jumlah DPT'));
    }, [dispatch]);

    const isRtl = useSelector((state: IRootState) => state.themeConfig.rtlClass) === 'rtl';

    const [rowData, setRowData] = useState<JalurPendaftaran[]>([]);
    const [page, setPage] = useState<number>(1);
    const PAGE_SIZES = [10, 20, 30, 50, 100];
    const [pageSize, setPageSize] = useState<number>(PAGE_SIZES[0]);
    const [recordsData, setRecordsData] = useState<JalurPendaftaran[]>([]);
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [search, setSearch] = useState<string>('');
    const [sortStatus, setSortStatus] = useState<DataTableSortStatus>({
        columnAccessor: 'id',
        direction: 'asc',
    });
    const [hideCols, setHideCols] = useState<string[]>([]);

    const fetchData = async () => {
        try {
            setIsLoading(true);
            const response = await tsrs2000.get(`${process.env.NEXT_PUBLIC_API_BASE_URL}/jalurpendaftaran`, 'Jalur Pendaftaran');
            const sortedData = sortBy(response.data, 'id');
            setRowData(sortedData);
            setRecordsData(sortedData);
        } catch (error) {
            console.error('Error fetching data:', error);
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

    const toggleColumnVisibility = (col: string) => {
        setHideCols((prev) => prev.includes(col) ? prev.filter((c) => c !== col) : [...prev, col]);
    };

    useEffect(() => {
        fetchData();
    }, []);

    useEffect(() => {
        setRecordsData(rowData.filter(item => item.name.toLowerCase().includes(search.toLowerCase())));
    }, [search, rowData]);

    useEffect(() => {
        const sortedData = sortBy(rowData, sortStatus.columnAccessor);
        setRecordsData(sortStatus.direction === 'desc' ? sortedData.reverse() : sortedData);
    }, [sortStatus, rowData]);

    useEffect(() => {
        const from = (page - 1) * pageSize;
        setRecordsData(rowData.slice(from, from + pageSize));
    }, [page, pageSize, rowData]);

    const columns = [
        { accessor: 'id', title: 'ID', hidden: hideCols.includes('id') },
        { accessor: 'name', title: 'Nama', hidden: hideCols.includes('name') },
        {
            accessor: 'actions',
            title: 'Aksi',
            render: (record: JalurPendaftaran) => (
                <div className="text-center flex justify-center gap-2">
                    <JalurPendaftaranModalEdit id={record.id} />
                    <Delete URL={`${process.env.NEXT_PUBLIC_API_BASE_URL}/jalurpendaftaran`} id={record.id.toString()} onDeleteSuccess={fetchData} />
                </div>
            )
        }
    ];

    return (
        <div>
            {isLoading && <Loaders />}
            <div className="panel flex items-center p-3 text-primary">
                <div className="bg-primary text-white ring-2 ring-primary/30 rounded-full p-1.5">
                    <IconBell />
                </div>
                <span className="ml-3">SIMPOND: </span>
                <a href="https://tsrs.tech" target="_blank" rel="noreferrer" className="hover:underline">Data Jalur Pendaftaran</a>
            </div>

            <div className='mt-6'>
                <JalurPendaftaranModalAdd />
            </div>

            <div className="panel mt-6">
                <div className="mb-5 flex flex-col gap-5 md:flex-row md:items-center">
                    <h5 className="text-lg font-semibold">Data Jalur Pendaftaran</h5>
                    <div className="flex gap-5 ml-auto">
                        <Dropdown
                            placement={`${isRtl ? 'bottom-end' : 'bottom-start'}`}
                            btnClassName="flex items-center border font-semibold rounded-md px-4 py-2"
                            button={
                                <>
                                    <span className="mr-1">Columns</span>
                                    <IconCaretDown className="w-5 h-5" />
                                </>
                            }
                        >
                            <ul>
                                {columns.map((col, i) => (
                                    <li key={i} className="flex items-center" onClick={() => toggleColumnVisibility(col.accessor)}>
                                        <input type="checkbox" checked={!col.hidden} readOnly className="form-checkbox" />
                                        <span className="ml-2">{col.title}</span>
                                    </li>
                                ))}
                            </ul>
                        </Dropdown>
                        <input type="text" placeholder="Cari..." value={search} onChange={(e) => setSearch(e.target.value)} className="form-input" />
                        <button onClick={fetchData} className="bg-primary text-white px-6 py-2 rounded">Cari</button>
                    </div>
                </div>

                <DataTable
                    className="table-hover"
                    records={recordsData}
                    columns={columns.map(col => ({ ...col, sortable: true }))}
                    highlightOnHover
                    totalRecords={rowData.length}
                    recordsPerPage={pageSize}
                    page={page}
                    onPageChange={setPage}
                    recordsPerPageOptions={PAGE_SIZES}
                    onRecordsPerPageChange={setPageSize}
                    sortStatus={sortStatus}
                    onSortStatusChange={setSortStatus}
                    minHeight={200}
                    paginationText={({ from, to, totalRecords }) => `Showing ${from} to ${to} of ${totalRecords} entries`}
                />
            </div>
        </div>
    );
};

Index.getLayout = function getLayout(page: React.ReactNode) {
    return <SuperAdminLayout>{page}</SuperAdminLayout>;
};

export default Index;
