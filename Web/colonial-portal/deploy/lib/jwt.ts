const JWT_SECRET = process.env.JWT_SECRET || 'colonial1947';

export interface TokenPayload {
  userId: number;
  username: string;
  role: string;
  department: string;
  iat?: number;
  exp?: number;
}

function base64UrlToBase64(value: string): string {
  return value.replace(/-/g, '+').replace(/_/g, '/');
}

function base64ToBase64Url(value: string): string {
  return value.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/g, '');
}

function decodeBase64UrlUtf8(value: string): string {
  const base64 = base64UrlToBase64(value);
  const padded = base64 + '='.repeat((4 - (base64.length % 4)) % 4);

  // atob is available in the Edge runtime.
  const binary = atob(padded);
  const bytes = new Uint8Array(binary.length);
  for (let i = 0; i < binary.length; i++) {
    bytes[i] = binary.charCodeAt(i);
  }
  return new TextDecoder().decode(bytes);
}

function encodeUtf8Base64Url(value: string): string {
  const bytes = new TextEncoder().encode(value);
  let binary = '';
  for (let i = 0; i < bytes.length; i++) {
    binary += String.fromCharCode(bytes[i]);
  }
  return base64ToBase64Url(btoa(binary));
}

async function hmacSha256Base64Url(secret: string, data: string): Promise<string> {
  const key = await crypto.subtle.importKey(
    'raw',
    new TextEncoder().encode(secret),
    { name: 'HMAC', hash: 'SHA-256' },
    false,
    ['sign']
  );

  const signature = await crypto.subtle.sign('HMAC', key, new TextEncoder().encode(data));
  const bytes = new Uint8Array(signature);
  let binary = '';
  for (let i = 0; i < bytes.length; i++) {
    binary += String.fromCharCode(bytes[i]);
  }
  return base64ToBase64Url(btoa(binary));
}

function timingSafeEqual(a: string, b: string): boolean {
  if (a.length !== b.length) return false;
  let result = 0;
  for (let i = 0; i < a.length; i++) {
    result |= a.charCodeAt(i) ^ b.charCodeAt(i);
  }
  return result === 0;
}

// VULNERABILITY 1: Accepts alg=none tokens
export async function verifyToken(token: string): Promise<TokenPayload | null> {
  try {
    // First check if it's an alg=none token
    const parts = token.split('.');
    if (parts.length === 3) {
      const header = JSON.parse(decodeBase64UrlUtf8(parts[0]));
      
      // CRITICAL FLAW: Accept alg=none tokens without verification
      if (header.alg === 'none' || header.alg === 'None' || header.alg === 'NONE') {
        const payload = JSON.parse(decodeBase64UrlUtf8(parts[1]));
        return payload as TokenPayload;
      }
    }

    // VULNERABILITY 2: Weak secret (colonial1947)
    if (parts.length !== 3) return null;
    const [encodedHeader, encodedPayload, encodedSignature] = parts;

    const header = JSON.parse(decodeBase64UrlUtf8(encodedHeader));
    if (header.alg !== 'HS256') {
      return null;
    }

    const signingInput = `${encodedHeader}.${encodedPayload}`;
    const expectedSignature = await hmacSha256Base64Url(JWT_SECRET, signingInput);
    if (!timingSafeEqual(expectedSignature, encodedSignature)) {
      return null;
    }

    const payload = JSON.parse(decodeBase64UrlUtf8(encodedPayload)) as TokenPayload;
    if (typeof payload.exp === 'number') {
      const nowSeconds = Math.floor(Date.now() / 1000);
      if (nowSeconds >= payload.exp) return null;
    }
    return payload;
  } catch (error) {
    return null;
  }
}

export async function generateToken(payload: Omit<TokenPayload, 'iat' | 'exp'>): Promise<string> {
  const header = { alg: 'HS256', typ: 'JWT' };
  const nowSeconds = Math.floor(Date.now() / 1000);
  const fullPayload: TokenPayload = {
    ...payload,
    iat: nowSeconds,
    exp: nowSeconds + 24 * 60 * 60,
  };

  const encodedHeader = encodeUtf8Base64Url(JSON.stringify(header));
  const encodedPayload = encodeUtf8Base64Url(JSON.stringify(fullPayload));
  const signingInput = `${encodedHeader}.${encodedPayload}`;
  const signature = await hmacSha256Base64Url(JWT_SECRET, signingInput);
  return `${signingInput}.${signature}`;
}

// Helper to create unsigned token (for testing/exploitation)
export function createUnsignedToken(payload: TokenPayload): string {
  const header = { alg: 'none', typ: 'JWT' };
  const encodedHeader = encodeUtf8Base64Url(JSON.stringify(header));
  const encodedPayload = encodeUtf8Base64Url(JSON.stringify(payload));
  return `${encodedHeader}.${encodedPayload}.`;
}
