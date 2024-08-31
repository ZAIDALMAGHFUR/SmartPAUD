'use server'

import { cookies } from 'next/headers'

export async function storeCookie(key: string, value: any) {
    console.log(key);
    console.log(value);

    await cookies().set('key', 'value');
    console.log('cobain');

}
