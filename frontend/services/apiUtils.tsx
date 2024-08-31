// services/apiUtils.ts
import { getCookie, deleteCookie} from 'cookies-next';
import { showAlert } from '@/utils/alertFunction';
export const tsrs2000 = {
    post: async (url: string, data: Record<string, any>, postType: string) => {
        const accessToken = getCookie('access_token');

        if (!accessToken) {
            showAlert(15, 'error', 'Access token is missing');
            throw new Error('Access token is missing');
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                },
                body: JSON.stringify(data),
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully created ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error saving data';
                let errorDetails = errorMessage;

                if (responseData.errors) {
                    const fieldErrors = Object.values(responseData.errors).flat();
                    errorDetails = `${errorMessage} ${fieldErrors.join(', ')}`;
                }

                showAlert(15, 'error', errorDetails);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    put: async (url: string, data: Record<string, any>, postType: string) => {
        const accessToken = getCookie('access_token');

        if (!accessToken) {
            showAlert(15, 'error', 'Access token is missing');
            throw new Error('Access token is missing');
        }

        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                },
                body: JSON.stringify(data),
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error saving data';
                let errorDetails = errorMessage;

                if (responseData.errors) {
                    const fieldErrors = Object.values(responseData.errors).flat();
                    errorDetails = `${errorMessage} ${fieldErrors.join(', ')}`;
                }

                showAlert(15, 'error', errorDetails);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    lockscreen: async (url: string, postType: string) => {
        const accessToken = getCookie('access_token');

        if (!accessToken) {
            showAlert(15, 'error', 'Access token is missing');
            throw new Error('Access token is missing');
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                },
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully  ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error saving data';
                let errorDetails = errorMessage;

                if (responseData.errors) {
                    const fieldErrors = Object.values(responseData.errors).flat();
                    errorDetails = `${errorMessage} ${fieldErrors.join(', ')}`;
                }

                showAlert(15, 'error', errorDetails);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    get: async (url: string,  postType: string) => {
        const accessToken = getCookie('access_token');

        if (!accessToken) {
            showAlert(15, 'error', 'Access token is missing');
            throw new Error('Access token is missing');
        }

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${accessToken}`,
                },
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully  ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error fetching data';
                showAlert(15, 'error', errorMessage);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    getNonAuth: async (url: string,  postType: string) => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully  ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error fetching data';
                showAlert(15, 'error', errorMessage);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    postRegister: async (url: string, data: Record<string, any>, postType: string) => {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully created ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error saving data';
                let errorDetails = errorMessage;

                if (responseData.errors) {
                    const fieldErrors = Object.values(responseData.errors).flat();
                    errorDetails = `${errorMessage} ${fieldErrors.join(', ')}`;
                }

                showAlert(15, 'error', errorDetails);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    postWithImages: async (url: string, data: FormData, postType: string) => {
        const accessToken = getCookie('access_token');

        if (!accessToken) {
            showAlert(15, 'error', 'Access token is missing');
            throw new Error('Access token is missing');
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                },
                body: data,
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully created ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error saving data';
                let errorDetails = errorMessage;

                if (responseData.errors) {
                    const fieldErrors = Object.values(responseData.errors).flat();
                    errorDetails = `${errorMessage} ${fieldErrors.join(', ')}`;
                }

                showAlert(15, 'error', errorDetails);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

    putWithImages: async (url: string, data: FormData, postType: string) => {
        const accessToken = getCookie('access_token');

        if (!accessToken) {
            showAlert(15, 'error', 'Access token is missing');
            throw new Error('Access token is missing');
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                },
                body: data,
            });

            const responseData = await response.json();

            if (response.ok) {
                showAlert(15, 'success', `Successfully created ${postType}`);
                return responseData;
            } else {
                const errorMessage = responseData.message || 'Error saving data';
                let errorDetails = errorMessage;

                if (responseData.errors) {
                    const fieldErrors = Object.values(responseData.errors).flat();
                    errorDetails = `${errorMessage} ${fieldErrors.join(', ')}`;
                }

                showAlert(15, 'error', errorDetails);
                throw new Error(`Error: ${response.status} - ${response.statusText}`);
            }
        } catch (error) {
            console.error('Error handling form submission:', error);
            throw error;
        }
    },

};
