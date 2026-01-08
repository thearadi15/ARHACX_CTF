import { NextRequest, NextResponse } from 'next/server';
import { serialize } from 'cookie';

export const runtime = 'edge';

export async function POST(request: NextRequest) {
  const cookie = serialize('auth_token', '', {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'strict',
    maxAge: 0,
    path: '/',
  });

  const response = NextResponse.json({ success: true, message: 'Logged out' });
  response.headers.set('Set-Cookie', cookie);

  return response;
}
