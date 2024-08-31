'use server'
import { NextRequest, NextResponse } from "next/server";


export function middleware(req: NextRequest) {
    const res = new NextResponse();
    const token = req.cookies.get('access_token')?.value || "";
    const role = req.cookies.get('role')?.value || "";
    const pathname: string = req.nextUrl.pathname;
    let isLoggedIn: boolean = token != "" && role != "" ? true : false;

    // return NextResponse.json({coba:pathname})

    // Auth Page adalah route utama
    if (pathname == '/') {
        return NextResponse.redirect(new URL('/auth/login', req.url))
    }

    // Tidak bisa mengunjungi LoginPage ketika sudah login
    if (isLoggedIn && pathname.split('/')[1] == "auth") {
        return NextResponse.redirect(new URL(`/${role}/dashboard`, req.url))
    }

    // Tidak bisa mengunjungi Dashboard atau Page role lain
    if (isLoggedIn && pathname.split('/')[1] != role) {
        return NextResponse.redirect(new URL(`/${role}/dashboard`, req.url))
    }

    if (isLoggedIn) {
        return NextResponse.next();
    }

    // Mengizinkan ke Auth Page ketika sudah LogOut
    if (pathname.split('/')[1] == "auth") {
        return NextResponse.next();
    }

    return NextResponse.redirect(new URL('/auth/login', req.url))
}

export const config = {
    matcher: [
        '/',
        '/auth/:path*',
        '/superadmin/:path*',
        '/admin/:path*',
        // '/((?!_next/static|_next/image|assets|components|lib|store|styles|pages|$).*)',
    ]
}
