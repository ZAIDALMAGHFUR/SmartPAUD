import axios, { AxiosRequestConfig, AxiosResponse } from 'axios';
import { NextRequest, NextResponse } from "next/server";

const res = new NextResponse();

const createAxiosInstance = (req?: NextRequest) => {
    const instance = axios.create({
        baseURL: process.env.NEXT_PUBLIC_API_BASE_URL,
        timeout: 10000,
    });

    instance.interceptors.request.use(
        (config) => {
            const token = req?.cookies.get('token');
            if (token) {
                config.headers['Authorization'] = `Bearer ${token}`;
            }
            return config;
        },
        (error) => {
            return Promise.reject(error);
        }
    );

    instance.interceptors.response.use(
        (response) => response,
        (error) => {
            return Promise.reject(error);
        }
    );

    return instance;
};

export const axiosRequest = async <T>(
    endpoint: string,
    method: AxiosRequestConfig['method'] = 'GET',
    data?: AxiosRequestConfig['data']
): Promise<AxiosResponse<T>> => {
    const axiosInstance = createAxiosInstance();

    try {
        const response = await axiosInstance.request<T>({
            url: endpoint,
            method,
            data,
        });

        return response;
    } catch (error) {
        throw error;
    }
};
