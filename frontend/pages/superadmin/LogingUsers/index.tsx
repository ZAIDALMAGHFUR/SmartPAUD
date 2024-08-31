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
import { getCookie } from 'cookies-next';
import 'tippy.js/dist/tippy.css';
import IconCaretDown from '@/components/Icon/IconCaretDown';

interface Employee {
    namalengkap: string;
    nik: string;
    nobpjs: string;
}

interface User {
    username: string;
    email: string;
    employee: Employee;
}

interface LogData {
    id: number;
    ipaddress: string;
    browser: string;
    activity: string;
    url: string;
    method: string;
    keterangan: string;
    device: string;
    tgllogin: string;
    waktulogin: string;
    users: User;
}

const Index = () => {
    const dispatch = useDispatch();
    useEffect(() => {
        dispatch(setPageTitle('Login History'));
    }, [dispatch]);

    const isRtl = useSelector((state: IRootState) => state.themeConfig.rtlClass) === 'rtl';

    const [rowData, setRowData] = useState<LogData[]>([]);
    const [page, setPage] = useState(1);
    const PAGE_SIZES = [10, 20, 30, 50, 100];
    const [pageSize, setPageSize] = useState(PAGE_SIZES[0]);
    const [initialRecords, setInitialRecords] = useState<LogData[]>(sortBy(rowData, 'id'));
    const [recordsData, setRecordsData] = useState<LogData[]>(initialRecords);
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [search, setSearch] = useState('');
    const [sortStatus, setSortStatus] = useState<DataTableSortStatus>({
        columnAccessor: 'id',
        direction: 'asc',
    });
    const [hideCols, setHideCols] = useState<string[]>(['id', 'users.employee.nik', 'users.employee.nobpjs']);

    const handleSearchClick = async () => {
        try {
            const accessToken = getCookie('access_token');
            if (!accessToken) {
                throw new Error('Access token is missing');
            }
            if (!startDate || !endDate) {
                showAlert('error', 'Date is required');
                return;
            }
            setIsLoading(true);
            const response = await fetch(`${process.env.NEXT_PUBLIC_API_BASE_URL}/get-logingusers/${startDate}/${endDate}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    Authorization: `Bearer ${accessToken}`,
                },
            });

            if (!response.ok) {
                if (response.status === 400) {
                    const responseData = await response.json();
                    const errorMessage = responseData.message || 'Error saving data';
                    showAlert('error', errorMessage);
                } else {
                    throw new Error(`Error: ${response.status} - ${response.statusText}`);
                }
            }

            const responseData = await response.json();
            setRowData(responseData.data);
            const sortedData = sortBy(responseData.data, 'id');
            setInitialRecords(sortedData);
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

    const showHideColumns = (col: string) => {
        setHideCols((prevHideCols) =>
            prevHideCols.includes(col) ? prevHideCols.filter((d) => d !== col) : [...prevHideCols, col]
        );
    };

    useEffect(() => {
        setPage(1);
    }, [pageSize]);

    useEffect(() => {
        const from = (page - 1) * pageSize;
        const to = from + pageSize;
        setRecordsData(initialRecords.slice(from, to));
    }, [page, pageSize, initialRecords]);

    useEffect(() => {
        setInitialRecords(() => {
            return rowData.filter((item) => {
                return (
                    item.ipaddress.toLowerCase().includes(search.toLowerCase()) ||
                    item.browser.toLowerCase().includes(search.toLowerCase()) ||
                    item.activity.toLowerCase().includes(search.toLowerCase()) ||
                    item.url.toLowerCase().includes(search.toLowerCase()) ||
                    item.method.toLowerCase().includes(search.toLowerCase()) ||
                    item.keterangan.toLowerCase().includes(search.toLowerCase()) ||
                    item.device.toLowerCase().includes(search.toLowerCase()) ||
                    item.tgllogin.toLowerCase().includes(search.toLowerCase()) ||
                    item.waktulogin.toLowerCase().includes(search.toLowerCase()) ||
                    item.users.username.toLowerCase().includes(search.toLowerCase()) ||
                    item.users.email.toLowerCase().includes(search.toLowerCase()) ||
                    item.users.employee.namalengkap.toLowerCase().includes(search.toLowerCase()) ||
                    item.users.employee.nik.toLowerCase().includes(search.toLowerCase()) ||
                    item.users.employee.nobpjs.toLowerCase().includes(search.toLowerCase())
                );
            });
        });
    }, [search, rowData]);

    useEffect(() => {
        const data = sortBy(initialRecords, sortStatus.columnAccessor);
        setInitialRecords(sortStatus.direction === 'desc' ? data.reverse() : data);
        setPage(1);
    }, [sortStatus]);

    const cols = [
        { accessor: 'id', title: 'ID' },
        { accessor: 'ipaddress', title: 'Ip Address' },
        { accessor: 'browser', title: 'Browser' },
        { accessor: 'activity', title: 'Activity' },
        { accessor: 'url', title: 'Url' },
        { accessor: 'method', title: 'Method' },
        { accessor: 'keterangan', title: 'Keterangan' },
        { accessor: 'device', title: 'Device' },
        { accessor: 'tgllogin', title: 'Tgl Login' },
        { accessor: 'waktulogin', title: 'Waktu Login' },
        { accessor: 'users.username', title: 'Nama Users' },
        { accessor: 'users.email', title: 'Email Users' },
        { accessor: 'users.employee.namalengkap', title: 'Nama Pegawai' },
        { accessor: 'users.employee.nik', title: 'Nik Pegawai' },
        { accessor: 'users.employee.nobpjs', title: 'No BPJS Pegawai' },
    ];

    return (
        <div>
            {isLoading && <Loaders />}
            <div className="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary">
                <div className="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                    <IconBell />
                </div>
                <span className="ltr:mr-3 rtl:ml-3">TSRS: </span>
                <a href="https://tsrs.tech" target="_blank" className="block hover:underline" rel="noreferrer">
                    Login History
                </a>
            </div>

            <div className="panel mt-6">
                <div className="mb-5 flex flex-col gap-5 md:flex-row md:items-center">
                    <h5 className="text-lg font-semibold dark:text-white-light">Login History</h5>
                    <div className="flex items-center gap-5 ltr:ml-auto rtl:mr-auto">
                        <div className="flex flex-col gap-5 md:flex-row md:items-center mt-6">
                            <div className="dropdown">
                                <Dropdown
                                    placement={`${isRtl ? 'bottom-end' : 'bottom-start'}`}
                                    btnClassName="!flex items-center border font-semibold border-white-light dark:border-[#253b5c] rounded-md px-4 py-2 text-sm dark:bg-[#1b2e4b] dark:text-white-dark"
                                    button={
                                        <>
                                            <span className="ltr:mr-1 rtl:ml-1">Columns</span>
                                            <IconCaretDown className="w-5 h-5" />
                                        </>
                                    }
                                >
                                    <ul className="!min-w-[140px]">
                                        {cols.map((col, i) => (
                                            <li
                                                key={i}
                                                className="flex flex-col"
                                                onClick={(e) => {
                                                    e.stopPropagation();
                                                    e.preventDefault();
                                                    showHideColumns(col.accessor);
                                                }}
                                            >
                                                <div className="flex items-center">
                                                    <input
                                                        type="checkbox"
                                                        checked={!hideCols.includes(col.accessor)}
                                                        className="form-checkbox"
                                                        readOnly
                                                    />
                                                    <span className="ltr:ml-2 rtl:mr-2">{col.title}</span>
                                                </div>
                                            </li>
                                        ))}
                                    </ul>
                                </Dropdown>
                            </div>
                        </div>
                        <div className="flex flex-col">
                            <label>Start Date:</label>
                            <input type="datetime-local" className="form-input w-auto" value={startDate} onChange={(e) => setStartDate(e.target.value)} />
                        </div>
                        <div className="flex flex-col">
                            <label>End Date:</label>
                            <input type="datetime-local" className="form-input w-auto" value={endDate} onChange={(e) => setEndDate(e.target.value)} />
                        </div>
                        <div className="text-right mt-6">
                            <input type="text" className="form-input" placeholder="Search..." value={search} onChange={(e) => setSearch(e.target.value)} />
                        </div>
                        <div className="text-right mt-6">
                            <button className="bg-primary text-white px-4 py-2 rounded ml-7" onClick={handleSearchClick} > Search </button>
                        </div>
                    </div>
                </div>
                <div className="datatables">
                    <DataTable<LogData>
                        className="table-hover whitespace-nowrap"
                        records={recordsData}
                        columns={cols.map((col) => ({
                            ...col,
                            hidden: hideCols.includes(col.accessor),
                            sortable: true,
                        }))}
                        highlightOnHover
                        totalRecords={initialRecords.length}
                        recordsPerPage={pageSize}
                        page={page}
                        onPageChange={(p) => setPage(p)}
                        recordsPerPageOptions={PAGE_SIZES}
                        onRecordsPerPageChange={setPageSize}
                        sortStatus={sortStatus}
                        onSortStatusChange={setSortStatus}
                        minHeight={200}
                        paginationText={({ from, to, totalRecords }) => `Showing ${from} to ${to} of ${totalRecords} entries`}
                    />
                </div>
            </div>
        </div>
    );
};

Index.getLayout = function getLayout(page: React.ReactNode) {
    return <SuperAdminLayout>{page}</SuperAdminLayout>;
};

export default Index;
