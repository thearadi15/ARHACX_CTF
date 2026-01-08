import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';
import { verifyToken } from './lib/jwt';

export function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;

  // Public routes
  if (pathname === '/' || pathname === '/api/auth/login' || pathname.startsWith('/_next') || pathname.startsWith('/static')) {
    return NextResponse.next();
  }

  // Get token from cookie
  const token = request.cookies.get('auth_token')?.value;

  if (!token) {
    // Redirect to login for protected pages
    if (pathname.startsWith('/dashboard') || pathname.startsWith('/classified')) {
      return NextResponse.redirect(new URL('/', request.url));
    }
    return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
  }

  // Verify token
  const payload = verifyToken(token);
  
  if (!payload) {
    return NextResponse.json({ error: 'Invalid token' }, { status: 401 });
  }

  // VULNERABILITY 3: Flawed role checking logic
  // Check admin routes - but the check is bypassable
  if (pathname.startsWith('/classified') || pathname.startsWith('/api/classified')) {
    // FLAW: Using loose string comparison and wrong property check
    // Should check payload.role === 'administrator' but checks 'admin' instead
    if (payload.role !== 'admin' && payload.role !== 'administrator') {
      // ADDITIONAL FLAW: Doesn't check if department field can bypass
      // If someone sets department='administrator', it might slip through other checks
      if (payload.department !== 'High Command') {
        return NextResponse.json({ 
          error: 'Access Denied: Administrator privileges required',
          hint: 'Perhaps the old colonial records mention other access methods...'
        }, { status: 403 });
      }
    }
  }

  // Officer routes
  if (pathname.startsWith('/intelligence')) {
    if (payload.role !== 'officer' && payload.role !== 'administrator') {
      return NextResponse.json({ error: 'Officers only' }, { status: 403 });
    }
  }

  // Add user info to headers for API routes
  const requestHeaders = new Headers(request.headers);
  requestHeaders.set('x-user-id', payload.userId.toString());
  requestHeaders.set('x-user-role', payload.role);
  requestHeaders.set('x-user-dept', payload.department);

  return NextResponse.next({
    request: {
      headers: requestHeaders,
    },
  });
}

export const config = {
  matcher: [
    '/dashboard/:path*',
    '/intelligence/:path*',
    '/classified/:path*',
    '/api/:path*',
  ],
};
